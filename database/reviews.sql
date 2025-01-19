drop table if exists review;
create table review (    
    reviewID integer not null primary key autoincrement,    
    rating integer default 0,
    content text not null,
    created_at text,
    updated_at text,
    userID integer not null,
    postID integer not null,
    foreign key (userID) references user(userID),
    foreign key (postID) references post(postID)
); 

