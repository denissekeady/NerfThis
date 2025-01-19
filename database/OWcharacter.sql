drop table if exists OWcharacter;
create table OWcharacter (
    characterID integer not null primary key autoincrement,
    charname varchar(20) not null,    
    chartype varchar(10) not null
);

insert into OWcharacter values (null, "D.Va",  "Tank");
insert into OWcharacter values (null, "Doomfist", "Tank");
insert into OWcharacter values (null, "Junker Queen", "Tank");
insert into OWcharacter values (null, "Mauga", "Tank");
insert into OWcharacter values (null, "Orisa", "Tank");
insert into OWcharacter values (null, "Ramattra", "Tank");
insert into OWcharacter values (null, "Reinhardt", "Tank");
insert into OWcharacter values (null, "Roadhog", "Tank");
insert into OWcharacter values (null, "Sigma", "Tank");
insert into OWcharacter values (null, "Winston", "Tank");
insert into OWcharacter values (null, "Wrecking Ball", "Tank");
insert into OWcharacter values (null, "Zarya", "Tank");
insert into OWcharacter values (null, "Ashe", "Damage");
insert into OWcharacter values (null, "Bastion", "Damage");
insert into OWcharacter values (null, "Cassidy", "Damage");
insert into OWcharacter values (null, "Echo", "Damage");
insert into OWcharacter values (null, "Genji", "Damage");
insert into OWcharacter values (null, "Hanzo", "Damage");
insert into OWcharacter values (null, "Junkrat", "Damage");
insert into OWcharacter values (null, "Mei", "Damage");
insert into OWcharacter values (null, "Pharah", "Damage");
insert into OWcharacter values (null, "Reaper", "Damage");
insert into OWcharacter values (null, "Sojourn", "Damage");
insert into OWcharacter values (null, "Soldier: 76", "Damage");
insert into OWcharacter values (null, "Sombra", "Damage");
insert into OWcharacter values (null, "Symmetra", "Damage");
insert into OWcharacter values (null, "Torbjorn", "Damage");
insert into OWcharacter values (null, "Tracer", "Damage");
insert into OWcharacter values (null, "Venture", "Damage");
insert into OWcharacter values (null, "Widowmaker", "Damage");
insert into OWcharacter values (null, "Ana", "Support");
insert into OWcharacter values (null, "Baptiste", "Support");
insert into OWcharacter values (null, "Brigitte", "Support");
insert into OWcharacter values (null, "Illari", "Support");
insert into OWcharacter values (null, "Juno", "Support");
insert into OWcharacter values (null, "Kiriko", "Support");
insert into OWcharacter values (null, "Lifeweaver", "Support");
insert into OWcharacter values (null, "Lucio", "Support");
insert into OWcharacter values (null, "Mercy", "Support");
insert into OWcharacter values (null, "Moira", "Support");
insert into OWcharacter values (null, "Zenyatta", "Support");