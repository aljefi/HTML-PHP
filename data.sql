drop table if exists books_authors;
drop table if exists books;
drop table if exists authors;

create table books
(
    id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    title   varchar(256),
    grade   integer,
    is_read bool
);

create table authors
(
    id        INTEGER PRIMARY KEY AUTO_INCREMENT,
    firstname varchar(256),
    lastname  varchar(256),
    grade     integer
)
;

CREATE TABLE books_authors (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    book_id INTEGER,
    author_id INTEGER
);

insert into authors values (null, 'Elisabeth', 'Robson', 5); # 1
insert into authors values (null, 'Eric', 'Freeman', 1); # 2
insert into authors values (null, 'Aleksandr', 'Jefimov', 1); # 3
insert into books values (null, 'Head First Html and CSS', 5, true);
insert into books values (null, 'My Book', null, false);
insert into books_authors value (null, 1, 2);
insert into books_authors value (null, 1, 1);
insert into books_authors value (null, 2, 1);


# SELECT books.title, authors.firstname, authors.lastname, books.grade, books.is_read
# FROM books_authors
# JOIN books ON books.id = books_authors.book_id
# JOIN authors ON authors.id = books_authors.author_id;
#
# SELECT books.id, authors.id, books.grade, books.is_read
# FROM books_authors
#          JOIN books ON books.id = books_authors.book_id
#          JOIN authors ON authors.id = books_authors.author_id
# where books.id = 1;
#
# SELECT books.title, GROUP_CONCAT(CONCAT(authors.firstname, ' ', authors.lastname)) AS authors, books.grade, books.is_read
# FROM books_authors
#          JOIN books ON books.id = books_authors.book_id
#          JOIN authors ON authors.id = books_authors.author_id
# GROUP BY books.id;

