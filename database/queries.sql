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
   created_at timestamp DEFAULT CURRENT_TIMESTAMP,
   updated_at timestamp DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE customers ADD status int default 1;





















-- SELECT * From ( 
    
--             SELECT 
--                 orders.user_id as c_id,
--                 ( SELECT name from customers WHERE orders.user_id = customers.id ) as customer_name,
--                 'POS' as type,
--                 orders.created_at as dateandtime,
--                 'des' as des,
--                 '0' as credit,
--                 '1' as debit,
--                 orders.total as amount
--                 FROM `orders`
    
--             UNION All
--             SELECT 
--             transections.customer_id as c_id,
--             ( SELECT name from customers WHERE transections.customer_id = customers.id ) as customer_name,
--             'Transactions' as type,
--             transections.date as dateandtime,
--             CONVERT(transections.description,char) as des,
--             CONVERT(transections.credit,char) as credit,
--             CONVERT(transections.debit,char) as debit,
--             transections.amount as amount
--             FROM `transections`
    
--             UNION All
--             SELECT 
--             sale_invoices.customer_id as c_id,
--             ( SELECT name from customers WHERE sale_invoices.customer_id = customers.id ) as customer_name,
--             'SaleInvoice' as type,
--             sale_invoices.date as dateandtime,
--             CONVERT(sale_invoices.description,char) as des,
--             '0' as credit,
--             '1' as debit,
--             sale_invoices.amount as amount
--             FROM `sale_invoices`
    
--     ) mytable where c_id = 8 order by dateandtime
           