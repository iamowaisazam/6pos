-------
ALTER TABLE orders ADD total double;
ALTER TABLE orders ADD is_cancel double default 0;
ALTER TABLE orders DROP is_cancel;
ALTER TABLE orders ADD status double default 0;


create table sale_invoices(
   id BIGINT(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
   customer_id BIGINT unsigned not null,
   amount double not null,
   description TEXT NOT NULL,
   date timestamp DEFAULT CURRENT_TIMESTAMP,
   created_at timestamp DEFAULT CURRENT_TIMESTAMP
);