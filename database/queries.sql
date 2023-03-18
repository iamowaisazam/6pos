-------
ALTER TABLE orders ADD total double;
ALTER TABLE orders ADD is_cancel double default 0;
ALTER TABLE orders DROP is_cancel;
ALTER TABLE orders ADD status double default 0;
