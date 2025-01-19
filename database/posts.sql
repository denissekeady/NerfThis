drop table if exists post;
create table post (    
    postID integer not null primary key autoincrement,    
    title varchar(40) not null,
    platform varchar(40),
    posttype varchar(20),
    content text default '',
    created_at text,
    updated_at text,
    characterID integer not null,
    userID integer not null,
    foreign key (characterID) references OWcharacter(characterID),
    foreign key (userID) references user(userID)
); 
