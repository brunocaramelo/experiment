create table tickets(
	id bigInt unsigned primary key not null auto_increment,
    name varchar(255),
    bar_code varchar(255),
    status varchar(255),
    due_date date,
    account_id int,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FK_account_id FOREIGN KEY (account_id)
    REFERENCES accounts(id)
);
