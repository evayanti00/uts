create database uts;
use uts;
create table product (
	id_product INT Auto_INCREMENT PRIMARY KEY,
    nama_product VARCHAR (100) not null,
    katagori VARCHAR (100) not null,
    harga decimal (15,1) not null,
    stok int not null check (stok>=0)
);
create table transaksi (
	id_transaksi INT Auto_INCREMENT PRIMARY KEY,
    id_product int,
    jumlah_beli int not null,
    tanggal_transaksi datetime default current_timestamp,
    foreign key (id_product) references product (id_product)
);
INSERT INTO product (nama_product, katagori, harga, stok)
VALUES
('Asus VivoBook', 'Laptop', 8500000, 10),
('Lenovo IdeaPad', 'Laptop', 9200000, 4),
('Samsung A15', 'Smartphone', 3200000, 7),
('iPhone 13', 'Smartphone', 11000000, 3);
select * from product;

INSERT INTO transaksi (id_product, jumlah_beli)
VALUES
(1, 2),
(2, 1),
(4, 1);
select * from transaksi;