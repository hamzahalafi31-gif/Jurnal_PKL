<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\PetugasModel;
use App\Models\BukuModel;
use App\Models\UsersModel;
use App\Models\PengaturanModel;
use App\Models\DetailPeminjamanModel;
use CodeIgniter\Database\RawSql;

class Peminjaman extends BaseController
{
    protected $peminjaman;
    protected $anggota;
    protected $petugas;
    protected $buku;
    protected $users;
    protected $pengaturan;
    protected $detailPeminjaman;

    public function __construct()
    {
        $this->peminjaman = new PeminjamanModel();
        $this->anggota = new AnggotaModel();
        $this->petugas = new PetugasModel();
        $this->buku = new BukuModel();
        $this->users = new UsersModel();
        $this->pengaturan = new \App\Models\PengaturanModel();
        $this->detailPeminjaman = new DetailPeminjamanModel();
    }

    /**
     * Mengurangi stok buku sebanyak satu untuk setiap id buku.
     */
    private function kurangiStok(array $idBuku): void
    {
        foreach ($idBuku as $id) {
            $this->buku->where('id_buku', $id)
                ->where('tersedia >', 0)
                ->set('tersedia', 'tersedia - 1', false)
                ->update();
        }
    }

    /**
     * Menambah stok buku sebanyak satu untuk setiap id buku.
     */
    private function tambahStok(array $idBuku): void
    {
        foreach ($idBuku as $id) {
            $this->buku->where('id_buku', $id)
                ->set('tersedia', 'tersedia + 1', false)
                ->update();
        }
    }

    /**
     * Mengambil data buku berdasarkan daftar id dan memastikan semuanya ada.
     */
    private function getBukuMap(array $idBuku): array
    {
        if (empty($idBuku)) {
            return [];
        }

        $daftarBuku = $this->buku->whereIn('id_buku', $idBuku)->findAll();

        return array_column($daftarBuku, null, 'id_buku');
    }

    

public function index()
{
    $session = session();
    $keyword = $this->request->getGet('keyword');
    $status = $this->request->getGet('status');

    $builder = $this->peminjaman->select('
        peminjaman.*,
        users.nama as nama_anggota,
        anggota.nis,
        petugas_user.nama as nama_petugas
    ');

    $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');
    $builder->join('users', 'users.id = anggota.user_id');
    $builder->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');
    $builder->join('users as petugas_user', 'petugas_user.id = petugas.user_id', 'left');

    // Anggota hanya bisa melihat peminjaman miliknya sendiri
    if ($session->get('role') === 'anggota') {
        $anggotaData = $this->anggota->getByUserId($session->get('id'));

        if ($anggotaData) {
            $builder->where('peminjaman.id_anggota', $anggotaData['id_anggota']);
        } else {
            $builder->where('peminjaman.id_peminjaman', 0);
        }
    }

    // Pencarian nama anggota, NIS, dan judul semua buku
    if ($keyword) {
        $bukuIds = $this->buku
            ->select('id_buku')
            ->like('judul', $keyword)
            ->findAll();

        $builder->groupStart()
            ->like('users.nama', $keyword)
            ->orLike('anggota.nis', $keyword);

        foreach ($bukuIds as $buku) {
            $idBuku = (int) $buku['id_buku'];

            $builder->orWhere(
                "peminjaman.id_peminjaman IN (
                    SELECT id_peminjaman
                    FROM detail_peminjaman
                    WHERE id_buku = {$idBuku}
                )",
                null,
                false
            );

            // Tetap mendukung data peminjaman lama
            $builder->orWhere('peminjaman.id_buku', $idBuku);
        }

        $builder->groupEnd();
    }

    // Filter status
    if ($status) {
        $builder->where('peminjaman.status', $status);
    }

    $builder->orderBy('peminjaman.tanggal_pinjam', 'DESC');

    $data['peminjaman'] = $this->peminjaman->attachBuku(
        $builder->paginate(10)
    );

    $data['pager'] = $this->peminjaman->pager;
    $data['keyword'] = $keyword;
    $data['status'] = $status;

    return view('peminjaman/index', $data);
}

    public function create()
    {
        $session = session();
        $data['buku'] = $this->buku->where('tersedia >', 0)->orderBy('judul', 'ASC')->findAll();
        $data['petugas'] = $this->petugas->getAllWithUser();
        $data['pengaturan'] = $this->pengaturan->first();

        if ($session->get('role') === 'anggota') {
            $anggotaData = $this->anggota->getByUserId($session->get('id'));
            if ($anggotaData) {
                $data['anggota'] = [$anggotaData];
            } else {
                return redirect()->to('/peminjaman')->with('error', 'Data anggota tidak ditemukan');
            }
        } else {
            $data['anggota'] = $this->anggota->getAllWithUser();
        }

        return view('peminjaman/create', $data);
    }

    
    public function store()
    {
        $session = session();
        $validation = \Config\Services::validation();

        $rules = [
            'id_buku'         => 'required',
            'id_buku.*'       => 'is_natural_no_zero',
            'tanggal_pinjam'  => 'required',
            'tanggal_kembali' => 'required',
        ];

        if ($session->get('role') !== 'anggota') {
            $rules['id_anggota'] = 'required';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validation->getErrors()))
                ->withInput();
        }

        // Ambil daftar buku yang dipilih
        $idBuku = $this->peminjaman->getBukuIds(
            $this->request->getPost('id_buku')
        );

        if (empty($idBuku)) {
            return redirect()->back()
                ->with('error', 'Pilih minimal satu buku untuk dipinjam')
                ->withInput();
        }

        // Pastikan semua buku tersedia
        $bukuMap = $this->getBukuMap($idBuku);

        if (count($bukuMap) !== count($idBuku)) {
            return redirect()->back()
                ->with('error', 'Ada buku yang tidak ditemukan')
                ->withInput();
        }

        foreach ($idBuku as $id) {
            if ((int) $bukuMap[$id]['tersedia'] <= 0) {
                return redirect()->back()
                    ->with('error', 'Buku "' . esc($bukuMap[$id]['judul']) . '" tidak tersedia')
                    ->withInput();
            }
        }

        // Tentukan petugas dan status peminjaman
        $id_petugas = null;
        $status = 'dipinjam';

        if ($session->get('role') === 'petugas') {
            $petugasData = $this->petugas->getByUserId($session->get('id'));

            if ($petugasData) {
                $id_petugas = $petugasData['id_petugas'];
            }
        } elseif ($session->get('role') === 'anggota') {
            $status = 'dimohon';
        } else {
            $id_petugas = $this->request->getPost('id_petugas');
        }

        // Tentukan anggota
        $id_anggota = $this->request->getPost('id_anggota');

        if ($session->get('role') === 'anggota') {
            $anggotaData = $this->anggota->getByUserId($session->get('id'));

            if (!$anggotaData) {
                return redirect()->back()
                    ->with('error', 'Data anggota tidak ditemukan');
            }

            $id_anggota = $anggotaData['id_anggota'];
        }

        // Simpan satu ID buku pertama pada kolom lama (INT)
        // Semua buku tetap disimpan pada detail_peminjaman
        $data = [
            'id_anggota'      => $id_anggota,
            'id_petugas'      => $id_petugas,
            'id_buku'         => $idBuku[0],
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $status,
        ];

        $db = $this->peminjaman->db;
        $db->transBegin();

        // Simpan data utama peminjaman
        if (!$this->peminjaman->save($data)) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Data peminjaman gagal disimpan')
                ->withInput();
        }

        $idPeminjaman = $this->peminjaman->getInsertID();

        // Simpan seluruh buku ke tabel detail_peminjaman
        if (!$this->detailPeminjaman->replaceDetails($idPeminjaman, $idBuku)) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Detail buku gagal disimpan')
                ->withInput();
        }

        // Kurangi stok hanya jika langsung berstatus dipinjam
        if ($status === 'dipinjam') {
            $this->kurangiStok($idBuku);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Peminjaman gagal disimpan')
                ->withInput();
        }

        $db->transCommit();

        $msg = $status === 'dimohon'
            ? 'Pengajuan peminjaman berhasil dikirim, menunggu konfirmasi petugas!'
            : 'Peminjaman berhasil ditambahkan!';

        return redirect()->to('/peminjaman')->with('success', $msg);
    }


    
public function konfirmasi($id)
{
    $session = session();

    // Hanya petugas yang bisa konfirmasi
    if ($session->get('role') !== 'petugas') {
        return redirect()->to('/peminjaman')
            ->with('error', 'Hanya petugas yang bisa mengkonfirmasi peminjaman');
    }

    $peminjaman = $this->peminjaman->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data tidak ditemukan');
    }

    if ($peminjaman['status'] !== 'dimohon') {
        return redirect()->to('/peminjaman')
            ->with('error', 'Hanya peminjaman dengan status dimohon yang bisa dikonfirmasi');
    }

    $petugasData = $this->petugas->getByUserId($session->get('id'));

    if (!$petugasData) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data petugas tidak ditemukan');
    }

    // Ambil semua ID buku dari tabel detail_peminjaman
    $idBuku = $this->detailPeminjaman->getBukuIds($id);

    // Cadangan untuk data peminjaman lama yang belum memiliki detail
    if (empty($idBuku)) {
        $idBuku = $this->peminjaman->getBukuIds($peminjaman['id_buku']);
    }

    if (empty($idBuku)) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data buku pada peminjaman tidak ditemukan');
    }

    // Periksa keberadaan dan ketersediaan semua buku
    $bukuMap = $this->getBukuMap($idBuku);

    if (count($bukuMap) !== count($idBuku)) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Ada buku pada peminjaman yang sudah dihapus');
    }

    foreach ($idBuku as $id_buku) {
        if ((int) $bukuMap[$id_buku]['tersedia'] <= 0) {
            return redirect()->to('/peminjaman')
                ->with('error', 'Buku "' . esc($bukuMap[$id_buku]['judul']) . '" sudah tidak tersedia');
        }
    }

    // Mulai transaksi database
    $db = $this->peminjaman->db;
    $db->transBegin();

    $berhasil = $this->peminjaman->update($id, [
        'status'     => 'dipinjam',
        'id_petugas' => $petugasData['id_petugas'],
    ]);

    if (!$berhasil) {
        $db->transRollback();

        return redirect()->to('/peminjaman')
            ->with('error', 'Gagal memperbarui data peminjaman');
    }

    // Kurangi stok seluruh buku yang dipinjam
    $this->kurangiStok($idBuku);

    if ($db->transStatus() === false) {
        $db->transRollback();

        return redirect()->to('/peminjaman')
            ->with('error', 'Peminjaman gagal dikonfirmasi');
    }

    $db->transCommit();

    return redirect()->to('/peminjaman')
        ->with('success', 'Peminjaman berhasil dikonfirmasi!');
}


    public function tolak($id)
    {
        $session = session();

        if ($session->get('role') !== 'petugas') {
            return redirect()->to('/peminjaman')->with('error', 'Hanya petugas yang bisa menolak peminjaman');
        }

        $peminjaman = $this->peminjaman->find($id);

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
        }

        if ($peminjaman['status'] !== 'dimohon') {
            return redirect()->to('/peminjaman')->with('error', 'Hanya peminjaman dengan status dimohon yang bisa ditolak');
        }

        $this->peminjaman->update($id, ['status' => 'kembali']);

        return redirect()->to('/peminjaman')->with('success', 'Pengajuan peminjaman ditolak!');
    }

    public function edit($id)
    {
        $session = session();
        $peminjaman = $this->peminjaman->getPeminjamanWithRelations($id);

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
        }

        // Anggota hanya bisa edit peminjaman miliknya
        if ($session->get('role') === 'anggota') {
            $anggotaData = $this->anggota->getByUserId($session->get('id'));
            if ($anggotaData && $peminjaman['id_anggota'] != $anggotaData['id_anggota']) {
                return redirect()->to('/peminjaman')->with('error', 'Tidak diizinkan mengedit peminjaman orang lain');
            }
        }

        $data['peminjaman'] = $peminjaman;
        $data['buku'] = $this->buku->orderBy('judul', 'ASC')->findAll();
        $data['petugas'] = $this->petugas->getAllWithUser();

        if ($session->get('role') === 'anggota') {
            $anggotaData = $this->anggota->getByUserId($session->get('id'));
            if ($anggotaData) {
                $data['anggota'] = [$anggotaData];
            }
        } else {
            $data['anggota'] = $this->anggota->getAllWithUser();
        }

        return view('peminjaman/edit', $data);
    }

    
public function update($id)
{
    $session = session();
    $peminjaman = $this->peminjaman->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data tidak ditemukan');
    }

    // Anggota hanya bisa update peminjaman miliknya
    if ($session->get('role') === 'anggota') {
        $anggotaData = $this->anggota->getByUserId($session->get('id'));

        if (!$anggotaData || $peminjaman['id_anggota'] != $anggotaData['id_anggota']) {
            return redirect()->to('/peminjaman')
                ->with('error', 'Tidak diizinkan mengupdate peminjaman orang lain');
        }
    }

    $validation = \Config\Services::validation();

    $rules = [
        'id_buku'         => 'required',
        'id_buku.*'       => 'is_natural_no_zero',
        'tanggal_pinjam'  => 'required',
        'tanggal_kembali' => 'required',
        'status'          => 'required',
    ];

    if ($session->get('role') !== 'anggota') {
        $rules['id_anggota'] = 'required';
    }

    $validation->setRules($rules);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()
            ->with('error', implode('<br>', $validation->getErrors()))
            ->withInput();
    }

    // Ambil daftar buku lama dari tabel detail_peminjaman
    $oldBukuIds = $this->detailPeminjaman->getBukuIds($id);

    // Cadangan untuk data peminjaman lama
    if (empty($oldBukuIds)) {
        $oldBukuIds = $this->peminjaman->getBukuIds($peminjaman['id_buku']);
    }

    // Ambil daftar buku baru
    $newBukuIds = $this->peminjaman->getBukuIds(
        $this->request->getPost('id_buku')
    );

    if (empty($newBukuIds)) {
        return redirect()->back()
            ->with('error', 'Pilih minimal satu buku untuk dipinjam')
            ->withInput();
    }

    // Periksa semua buku
    $semuaIdBuku = array_values(
        array_unique(array_merge($oldBukuIds, $newBukuIds))
    );

    $bukuMap = $this->getBukuMap($semuaIdBuku);

    if (count($bukuMap) !== count($semuaIdBuku)) {
        return redirect()->back()
            ->with('error', 'Ada buku yang tidak ditemukan')
            ->withInput();
    }

    // Periksa perubahan status dan stok
    $statusLama = $peminjaman['status'];
    $statusBaru = $this->request->getPost('status');

    $statusStok = ['dipinjam', 'terlambat'];

    $oldHoldsStock = in_array($statusLama, $statusStok, true);
    $newHoldsStock = in_array($statusBaru, $statusStok, true);

    $restoreIds = [];
    $takeIds = [];

    if ($oldHoldsStock && $newHoldsStock) {
        $restoreIds = array_values(array_diff($oldBukuIds, $newBukuIds));
        $takeIds = array_values(array_diff($newBukuIds, $oldBukuIds));
    } elseif ($oldHoldsStock) {
        $restoreIds = $oldBukuIds;
    } elseif ($newHoldsStock) {
        $takeIds = $newBukuIds;
    }

    foreach ($takeIds as $id_buku) {
        if ((int) $bukuMap[$id_buku]['tersedia'] <= 0) {
            return redirect()->back()
                ->with('error', 'Buku "' . esc($bukuMap[$id_buku]['judul']) . '" tidak tersedia')
                ->withInput();
        }
    }

    // Tentukan petugas
    $id_petugas = null;

    if ($session->get('role') === 'petugas') {
        $petugasData = $this->petugas->getByUserId($session->get('id'));

        if ($petugasData) {
            $id_petugas = $petugasData['id_petugas'];
        }
    } else {
        $id_petugas = $peminjaman['id_petugas'];
    }

    // Tentukan anggota
    $id_anggota = $peminjaman['id_anggota'];

    if ($session->get('role') !== 'anggota') {
        $id_anggota = $this->request->getPost('id_anggota');
    }

    // Simpan satu ID buku pada kolom INT
    // Seluruh daftar buku disimpan pada detail_peminjaman
    $data = [
        'id_anggota'      => $id_anggota,
        'id_petugas'      => $id_petugas,
        'id_buku'         => $newBukuIds[0],
        'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
        'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
        'status'          => $statusBaru,
    ];

    $db = $this->peminjaman->db;
    $db->transBegin();

    // Update data utama
    if (!$this->peminjaman->update($id, $data)) {
        $db->transRollback();

        return redirect()->back()
            ->with('error', 'Peminjaman gagal diupdate')
            ->withInput();
    }

    // Perbarui daftar buku pada tabel detail_peminjaman
    if (!$this->detailPeminjaman->replaceDetails($id, $newBukuIds)) {
        $db->transRollback();

        return redirect()->back()
            ->with('error', 'Daftar buku gagal diperbarui')
            ->withInput();
    }

    // Perbarui stok buku
    $this->tambahStok($restoreIds);
    $this->kurangiStok($takeIds);

    if ($db->transStatus() === false) {
        $db->transRollback();

        return redirect()->back()
            ->with('error', 'Peminjaman gagal diupdate')
            ->withInput();
    }

    $db->transCommit();

    return redirect()->to('/peminjaman')
        ->with('success', 'Peminjaman berhasil diupdate!');
}


   
public function delete($id)
{
    $session = session();
    $peminjaman = $this->peminjaman->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
    }

    // Anggota hanya bisa menghapus peminjaman miliknya
    if ($session->get('role') === 'anggota') {
        $anggotaData = $this->anggota->getByUserId($session->get('id'));

        if (!$anggotaData || $peminjaman['id_anggota'] != $anggotaData['id_anggota']) {
            return redirect()->to('/peminjaman')->with('error', 'Tidak diizinkan menghapus peminjaman orang lain');
        }

        if ($peminjaman['status'] !== 'dipinjam') {
            return redirect()->to('/peminjaman')->with('error', 'Anggota hanya bisa menghapus peminjaman yang statusnya dipinjam');
        }
    }

    $db = $this->peminjaman->db;

    // Lindungi data yang sudah memiliki riwayat
    $riwayat = [
        'pengembalian',
        'pengiriman',
        'penarikan',
        'transaksi'
    ];

    foreach ($riwayat as $tabel) {
        $jumlahRiwayat = $db->table($tabel)
            ->where('id_peminjaman', $id)
            ->countAllResults();

        if ($jumlahRiwayat > 0) {
            return redirect()->to('/peminjaman')->with(
                'error',
                'Peminjaman tidak bisa dihapus karena sudah memiliki riwayat'
            );
        }
    }

    // Ambil semua buku dari detail_peminjaman
    $idBuku = $this->detailPeminjaman->getBukuIds($id);

    // Fallback untuk data peminjaman lama
    if (empty($idBuku)) {
        $idBuku = $this->peminjaman->getBukuIds($peminjaman['id_buku']);
    }

    $db->transStart();

    // Kembalikan stok jika peminjaman masih aktif
    if (in_array($peminjaman['status'], ['dipinjam', 'terlambat'], true)) {
        $this->tambahStok($idBuku);
    }

    // Hapus data peminjaman
    // Detail peminjaman ikut terhapus melalui ON DELETE CASCADE
    $this->peminjaman->delete($id);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->to('/peminjaman')->with('error', 'Peminjaman gagal dihapus');
    }

    return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
}


   
public function detail($id)
{
    $session = session();
    $peminjaman = $this->peminjaman->getPeminjamanWithRelations($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
    }

    // Anggota hanya bisa lihat detail peminjaman miliknya
    if ($session->get('role') === 'anggota') {
        $anggotaData = $this->anggota->getByUserId($session->get('id'));

        if (!$anggotaData || $peminjaman['id_anggota'] != $anggotaData['id_anggota']) {
            return redirect()->to('/peminjaman')->with('error', 'Tidak diizinkan melihat detail peminjaman orang lain');
        }
    }

    // Ambil semua buku dari detail_peminjaman
    $idBuku = $this->detailPeminjaman->getBukuIds($id);

    // Fallback untuk data peminjaman lama
    if (empty($idBuku)) {
        $idBuku = $this->peminjaman->getBukuIds($peminjaman['id_buku']);
    }

    // Ambil informasi seluruh buku
    $bukuList = [];

    if (!empty($idBuku)) {
        $bukuList = $this->buku
            ->whereIn('id_buku', $idBuku)
            ->findAll();
    }

    // Kirim daftar buku ke halaman detail
    $peminjaman['buku_list'] = $bukuList;

    return view('peminjaman/detail', [
        'peminjaman' => $peminjaman
    ]);
}


    
public function kembalikan($id)
{
    $session = session();
    $peminjaman = $this->peminjaman->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data peminjaman tidak ditemukan');
    }

    if (!in_array($peminjaman['status'], ['dipinjam', 'terlambat'], true)) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Buku sudah dikembalikan');
    }

    // Hanya petugas dan admin yang boleh mengembalikan buku
    if ($session->get('role') === 'anggota') {
        return redirect()->to('/peminjaman')
            ->with('error', 'Hanya petugas yang bisa mengembalikan buku');
    }

    // Ambil tanggal dan pengaturan denda
    $tanggalSekarang = new \DateTimeImmutable(date('Y-m-d'));
    $tanggalBatas = new \DateTimeImmutable($peminjaman['tanggal_kembali']);

    $pengaturan = $this->pengaturan->first();
    $dendaPerHari = $pengaturan
        ? (float) $pengaturan['denda_per_hari']
        : 0;

    // Hitung keterlambatan
    $hariTerlambat = 0;

    if ($tanggalSekarang > $tanggalBatas) {
        $hariTerlambat = (int) $tanggalBatas
            ->diff($tanggalSekarang)->days;
    }

    // Tentukan status akhir
    if ($hariTerlambat > 0) {
        $status = 'terlambat';
        $denda = $hariTerlambat * $dendaPerHari;
    } else {
        $status = 'kembali';
        $denda = 0;
    }

    // Ambil semua ID buku dari detail_peminjaman
    $idBuku = $this->detailPeminjaman->getBukuIds($id);

    // Fallback untuk data peminjaman lama
    if (empty($idBuku)) {
        $idBuku = $this->peminjaman->getBukuIds(
            $peminjaman['id_buku']
        );
    }

    if (empty($idBuku)) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data buku dalam peminjaman tidak ditemukan');
    }

    $db = $this->peminjaman->db;
    $db->transBegin();

    // Update status peminjaman
    if (!$this->peminjaman->update($id, [
        'status' => $status
    ])) {
        $db->transRollback();

        return redirect()->to('/peminjaman')
            ->with('error', 'Gagal memperbarui status peminjaman');
    }

    // Tambahkan kembali stok seluruh buku
    $this->tambahStok($idBuku);

    // Simpan data pengembalian
    $pengembalianModel = new \App\Models\PengembalianModel();

    if (!$pengembalianModel->save([
        'id_peminjaman' => $id,
        'tanggal_dikembalikan' => date('Y-m-d'),
        'denda' => $denda,
    ])) {
        $db->transRollback();

        return redirect()->to('/peminjaman')
            ->with('error', 'Gagal menyimpan data pengembalian');
    }

    // Simpan data denda jika terlambat
    if ($denda > 0) {
        $idPengembalian = $pengembalianModel->getInsertID();

        $dendaModel = new \App\Models\DendaModel();

        if (!$dendaModel->save([
            'id_pengembalian' => $idPengembalian,
            'jumlah_denda' => $denda,
            'status' => 'belum_bayar',
        ])) {
            $db->transRollback();

            return redirect()->to('/peminjaman')
                ->with('error', 'Gagal menyimpan data denda');
        }
    }

    // Selesaikan transaksi database
    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Proses pengembalian gagal');
    }

    // Berikan pemberitahuan
    if ($hariTerlambat > 0) {
        return redirect()->to('/peminjaman')->with(
            'success',
            'Buku berhasil dikembalikan, tetapi terlambat ' .
            $hariTerlambat . ' hari. Denda: Rp ' .
            number_format($denda, 0, ',', '.')
        );
    }

    return redirect()->to('/peminjaman')->with(
        'success',
        'Buku berhasil dikembalikan tepat waktu. Tidak ada denda.'
    );
}



    
public function print()
{
    $session = session();
    $keyword = $this->request->getGet('keyword');
    $status = $this->request->getGet('status');

    $builder = $this->peminjaman->db->table('peminjaman');

    $builder->select('
        peminjaman.*,
        users.nama as nama_anggota,
        anggota.nis,
        petugas_user.nama as nama_petugas
    ');

    $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');
    $builder->join('users', 'users.id = anggota.user_id');
    $builder->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left');
    $builder->join('users as petugas_user', 'petugas_user.id = petugas.user_id', 'left');

    // Anggota hanya bisa print peminjaman miliknya
    if ($session->get('role') === 'anggota') {
        $anggotaData = $this->anggota->getByUserId($session->get('id'));

        if ($anggotaData) {
            $builder->where('peminjaman.id_anggota', $anggotaData['id_anggota']);
        } else {
            $builder->where('peminjaman.id_peminjaman', 0);
        }
    }

    // Pencarian nama anggota, NIS, dan judul buku
    if ($keyword) {
        $bukuIds = $this->buku
            ->select('id_buku')
            ->like('judul', $keyword)
            ->findAll();

        $builder->groupStart()
            ->like('users.nama', $keyword)
            ->orLike('anggota.nis', $keyword);

        foreach ($bukuIds as $buku) {
            $idBuku = (int) $buku['id_buku'];

            $builder->orWhere(
                "peminjaman.id_peminjaman IN (
                    SELECT id_peminjaman
                    FROM detail_peminjaman
                    WHERE id_buku = {$idBuku}
                )",
                null,
                false
            );

            // Mendukung data peminjaman lama
            $builder->orWhere('peminjaman.id_buku', $idBuku);
        }

        $builder->groupEnd();
    }

    // Filter status
    if ($status) {
        $builder->where('peminjaman.status', $status);
    }

    $builder->orderBy('peminjaman.tanggal_pinjam', 'DESC');

    $data['peminjaman'] = $this->peminjaman->attachBuku(
        $builder->get()->getResultArray()
    );

    $data['keyword'] = $keyword;
    $data['status'] = $status;
    $data['pengaturan'] = $this->pengaturan->first();

    return view('peminjaman/print', $data);
}

}
