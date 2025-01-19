drop table if exists user;
create table user (    
    userID integer not null primary key autoincrement,    
    username varchar(40) not null,    
    no_of_hrs integer not null,
    comment_banned boolean not null,
    disable_comments boolean not null
); 