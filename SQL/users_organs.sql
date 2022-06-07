create table client_organ(
	id int unsigned primary key auto_increment,
    account_id int unsigned,
    organ_id int unsigned,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
	updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);