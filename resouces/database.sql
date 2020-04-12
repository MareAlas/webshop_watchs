
/* BAZA ZA WEB SHOP SATOVA MARKO MARKOVIC */

/* DB radjena u POSTRESQL */

/* KATEGORIJE */
CREATE TABLE ecategories
(
  cat_id serial NOT NULL,
  cat_title text NOT NULL,
  CONSTRAINT ecategories_pkey PRIMARY KEY (cat_id)
)
WITH (
  OIDS=FALSE
);

insert into ecategories (cat_title) values ('Seiko'),('Boss'),('Casio'),('Armani'),('Fosill'),('Diesel'),('Guess'),('Swatch'),('Lorus'),
	('Tissot'),('Nautica'),('Skagen'),('S Oliver'),('Festina'),('Sector'),('Tommy Hilfiger'),('Bulova')

select * from ecategories

/* USERS */
CREATE TABLE users
(
  user_id serial NOT NULL,
  username text NOT NULL,
  email text NOT NULL,
  password text NOT NULL,
  user_photo text,
  CONSTRAINT users_pkey PRIMARY KEY (user_id)
)
WITH (
  OIDS=FALSE
);

insert into users (username, email, password)
values ('Marko', 'markovicm.1403@gmail.com', '123'), ('Mare', 'ibar026@yahoo.com', 'abc')

/* PROIZVODI */
CREATE TABLE products
(
  product_id serial NOT NULL,
  product_title text NOT NULL,
  product_ecategory_id int NOT NULL,
  product_price float NOT NULL,
  product_description text NOT NULL,
  product_image text NOT NULL,
  short_desc text NOT NULL,
  product_quantity int NOT NULL,
  CONSTRAINT products_pkey PRIMARY KEY (product_id)
)
WITH (
  OIDS=FALSE
);

select * from products

insert into products (product_title, product_ecategory_id, product_price, product_description, product_image, short_desc, product_quantity)
		values ('HUGO BOSS', 2, 58000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/bos1.jpg', 'Muski sat', 5),     
			('CASIO', 3, 43000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/casio1.jpg', 'Muski sat', 9),
			('HUGO BOSS', 2, 105000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/bos2.jpg', 'Muski sat', 3),
			('FOSILL', 5, 21000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/fosil1.jpg', 'Muski sat', 17),
			('FOSILL', 5, 28000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/fosil2.jpg', 'Muski sat', 14),
			('SEIKO', 1, 73000, 'Muski sat koji najpreciznije prikazuje vreme. Elagantan, svajcarsko japanske preciznosti i tacnosti. Dobro ide uz sportsko kezual kombinaciju odevanja, ali i uz svaku vrstu odela. Svidece se vasim sagovrnicima, prijateljima, partnerima, porpdici. Da, pravo je vreme...i tacno.', '../../resources/uploads/seiko1.jpg', 'Muski sat', 7)

select * from products

/* IZVESTAJI */

CREATE TABLE reports
(
  report_id serial NOT NULL,
  product_id int NOT NULL,
  report_price float NOT NULL,
  report_quantity int NOT NULL,
  order_id int NOT NULL,
  product_title text NOT NULL,
  CONSTRAINT reports_pkey PRIMARY KEY (report_id)
)
WITH (
  OIDS=FALSE
);

insert into reports(product_id, report_price, report_quantity, order_id, product_title) 
		values (1, 58000, 1, 1, 'HUGO BOSS'), (2, 86000, 2, 2, 'CASIO'), (3, 105000, 1, 3, 'HUGO BOSS'), (6, 73000, 1, 4, 'SEIKO')

/*  NARUDZBINE */
CREATE TABLE orders
(
  order_id serial NOT NULL,
  order_amount float NOT NULL,
  order_transaction text NOT NULL,
  order_status text NOT NULL,
  order_currency text NOT NULL,
  CONSTRAINT orders_pkey PRIMARY KEY (order_id)
)
WITH (
  OIDS=FALSE
);

insert into orders(order_amount, order_transaction, order_status, order_currency)
	values(58000, '1153881', 'Completed', 'RSD'), (86000, '14656581', 'Completed', 'RSD'), (105000, '3366581', 'Completed', 'RSD'), (73000, '3344611', 'Completed', 'RSD')

alter table orders add order_date date

update orders set order_date = '2020-04-08' where order_id = 1
update orders set order_date = '2020-04-09' where order_id = 2
update orders set order_date = '2020-04-10' where order_id = 3
update orders set order_date = '2020-04-11' where order_id = 4


/* KOMENTARI */
CREATE TABLE reviews
(
  review_id serial NOT NULL,
  review_name text NOT NULL,
  review_email text NOT NULL,
  review_text text NOT NULL,
  raiting int NOT NULL,
  review_date date,
  CONSTRAINT reviews_pkey PRIMARY KEY (review_id)
)
WITH (
  OIDS=FALSE
);

insert into reviews(review_name, review_email, review_text, raiting, review_date)
		values('Anonymus', 'anonimus@dark.net', 'Jako dobar proizvod, lep, kvalitetan, koristan', '5', '2020-04-11'),
		('John', 'john@gmail.com', 'Zanimljiv poklon', '4', '2020-04-10'),
		('Sun', 'sun@yahoo.com', 'Odnos kvalitet cena fenomenalno', '5', '2020-04-08')