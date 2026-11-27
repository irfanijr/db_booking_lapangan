USE db_booking_lapangan;

INSERT INTO
    lapangan (nama_lapangan, lokasi, harga_per_jam)
VALUES
    (
        'Lapangan Futsal A (Sintetis)',
        'Gedung Utama Lantai 1',
        150000.00
    ),
    (
        'Lapangan Futsal B (Vinyl)',
        'Gedung Utama Lantai 2',
        180000.00
    ),
    (
        'Lapangan Badminton Court 1',
        'Gedung Sayap Timur',
        75000.00
    );

INSERT INTO
    users (nama_lengkap, no_hp, email)
VALUES
    (
        'Budi Santoso',
        '081234567890',
        'budi.santoso@email.com'
    ),
    (
        'Siti Aminah',
        '081298765432',
        'siti.aminah@email.com'
    ),
    (
        'Andi Wijaya',
        '085611223344',
        'andi.wijaya@email.com'
    ),
    (
        'Rina Kusuma',
        '087755667788',
        'rina.kusuma@email.com'
    ),
    (
        'Dedi Pratama',
        '089699887766',
        'dedi.pratama@email.com'
    );

INSERT INTO
    bookings (
        lapangan_id,
        user_id,
        tgl_booking,
        jam_mulai,
        durasi,
        total_harga,
        status_pembayaran
    )
VALUES
    (
        1,
        1,
        '2026-10-02',
        '19:00:00',
        2,
        300000.00,
        'lunas'
    ),
    (
        2,
        2,
        '2026-10-05',
        '16:00:00',
        1,
        180000.00,
        'lunas'
    ),
    (
        3,
        3,
        '2026-10-10',
        '09:00:00',
        2,
        150000.00,
        'lunas'
    ),
    (
        1,
        4,
        '2026-10-15',
        '20:00:00',
        1,
        150000.00,
        'batal'
    ),
    (
        2,
        1,
        '2026-10-21',
        '18:00:00',
        2,
        360000.00,
        'lunas'
    ),
    (
        1,
        5,
        '2026-11-01',
        '15:00:00',
        2,
        300000.00,
        'lunas'
    ),
    (
        3,
        2,
        '2026-11-04',
        '10:00:00',
        3,
        225000.00,
        'lunas'
    ),
    (
        1,
        3,
        '2026-11-12',
        '21:00:00',
        1,
        150000.00,
        'pending'
    ),
    (
        2,
        4,
        '2026-11-18',
        '17:00:00',
        2,
        360000.00,
        'lunas'
    ),
    (
        1,
        1,
        '2026-11-25',
        '19:00:00',
        2,
        300000.00,
        'pending'
    );

SELECT
    b.id AS id_booking,
    u.nama_lengkap AS pemesan,
    l.nama_lapangan,
    b.tgl_booking,
    b.jam_mulai,
    b.durasi,
    b.total_harga,
    b.status_pembayaran
FROM
    bookings b
    INNER JOIN users u ON b.user_id = u.id
    INNER JOIN lapangan l ON b.lapangan_id = l.id;

SELECT
    b.id AS id_booking,
    u.nama_lengkap AS pemesan,
    l.nama_lapangan,
    b.tgl_booking,
    b.jam_mulai,
    b.total_harga,
    b.status_pembayaran
FROM
    bookings b
    INNER JOIN users u ON b.user_id = u.id
    INNER JOIN lapangan l ON b.lapangan_id = l.id
WHERE
    u.nama_lengkap LIKE '%Budi%';

SELECT
    b.id AS id_booking,
    u.nama_lengkap AS pemesan,
    l.nama_lapangan,
    b.tgl_booking,
    b.jam_mulai,
    b.total_harga,
    b.status_pembayaran
FROM
    bookings b
    INNER JOIN users u ON b.user_id = u.id
    INNER JOIN lapangan l ON b.lapangan_id = l.id
WHERE
    MONTH (b.tgl_booking) = 11
    AND YEAR (b.tgl_booking) = 2026
ORDER BY
    b.tgl_booking ASC,
    b.jam_mulai ASC;

SELECT
    l.nama_lapangan,
    COUNT(b.id) AS total_dibooking
FROM
    lapangan l
    LEFT JOIN bookings b ON l.id = b.lapangan_id
GROUP BY
    l.id,
    l.nama_lapangan
ORDER BY
    total_dibooking DESC;