create table gen_menu
(
    ID        int unsigned auto_increment
        primary key,
    NAME      varchar(200)     default 'menu' not null,
    PARENT_ID int unsigned     default '0'    null,
    LANG_ID   char(2)          default 'ru'   not null,
    MENU_TYPE varchar(500)     default 'menu' not null,
    METHOD    varchar(20)                     null,
    USER_TYPE tinyint unsigned default '0'    null
)
    charset = utf8;

create index LANG_ID
    on gen_menu (LANG_ID);

create index MENU_TYPE
    on gen_menu (MENU_TYPE);

create index PARENT_ID
    on gen_menu (PARENT_ID);

create index USER_TYPE
    on gen_menu (USER_TYPE);

create table gen_menu_order
(
    PARENT_ID int unsigned default '0' not null,
    MENU_ID   int unsigned default '0' not null,
    POSITION  int unsigned default '0' not null
)
    charset = utf8;

create index MENU_ID
    on gen_menu_order (MENU_ID);

create index PARENT_ID
    on gen_menu_order (PARENT_ID);

create table gen_message
(
    ID          int unsigned auto_increment
        primary key,
    TITLE       varchar(200)     default ''                    not null,
    ANNOTATION  mediumtext                                     null,
    CREATE_DATE datetime         default '1970-01-01 00:00:00' not null,
    USER_ID     int unsigned     default '1'                   not null,
    LANG_ID     char(2)          default 'ru'                  not null,
    PUBLIC      int unsigned     default '0'                   null,
    USER_TYPE   tinyint unsigned default '0'                   null
)
    charset = utf8;

create index LANG_ID
    on gen_message (LANG_ID);

create index USER_ID
    on gen_message (USER_ID);

create index USER_TYPE
    on gen_message (USER_TYPE);

create table gen_message_text
(
    MESSAGE_ID int unsigned default '0' not null,
    MESSAGE    mediumtext               null
)
    charset = utf8;

create index MESSAGE_ID
    on gen_message_text (MESSAGE_ID);

create table gen_mixed_menu_mess
(
    MENU_ID    int unsigned default '0' not null,
    MESSAGE_ID int unsigned default '0' not null
)
    charset = utf8;

create index MENU_ID
    on gen_mixed_menu_mess (MENU_ID);

create index MESSAGE_ID
    on gen_mixed_menu_mess (MESSAGE_ID);

create table gen_mixed_name_lang
(
    NAME_ID      int unsigned not null,
    NAME_LANG_ID int unsigned not null,
    constraint NAME_LANG_ID
        unique (NAME_LANG_ID)
)
    charset = utf8;

create index NAME_ID
    on gen_mixed_name_lang (NAME_ID);

create table gen_mixed_surname_lang
(
    SURNAME_ID      int unsigned not null,
    SURNAME_LANG_ID int unsigned not null
)
    charset = utf8
    row_format = COMPACT;

create index SURNAME_ID
    on gen_mixed_surname_lang (SURNAME_ID);

create index SURNAME_LANG_ID
    on gen_mixed_surname_lang (SURNAME_LANG_ID);

create table gen_name
(
    ID      int unsigned auto_increment
        primary key,
    USER_ID int unsigned not null,
    constraint ID
        unique (ID)
)
    charset = utf8
    row_format = COMPACT;

create index USER_ID
    on gen_name (USER_ID);

create table gen_name_lang
(
    ID           int unsigned auto_increment
        primary key,
    MALE_ID      int unsigned null,
    FNAME        varchar(45)  null,
    MALE_SNAME   varchar(45)  null,
    FEMALE_SNAME varchar(45)  null,
    LANG         char(3)      not null,
    constraint FNAME
        unique (FNAME),
    constraint ID
        unique (ID)
)
    charset = utf8;

create index MALE_ID
    on gen_name_lang (MALE_ID);

create table gen_person
(
    ID          int unsigned auto_increment
        primary key,
    FNAME_ID    int unsigned not null,
    SNAME_ID    int unsigned null,
    SURNAME_ID  int unsigned null,
    BSURNAME_ID int unsigned null,
    BDATE       datetime     null,
    DDATE       datetime     null,
    USER_ID     int unsigned not null
)
    charset = utf8;

create index BSURNAME_ID
    on gen_person (BSURNAME_ID);

create index FNAME_ID
    on gen_person (FNAME_ID);

create index SNAME_ID
    on gen_person (SNAME_ID);

create index SURNAME_ID
    on gen_person (SURNAME_ID);

create index USER_ID
    on gen_person (USER_ID);

create table gen_person_info_lang
(
    PERSON_ID int unsigned not null,
    INFO      mediumtext   null,
    LANG      char(3)      not null
)
    charset = utf8
    row_format = COMPACT;

create table gen_relation
(
    PID1             int unsigned null,
    PID2             int unsigned null,
    RELATION_TYPE_ID int unsigned null
)
    charset = utf8;

create index PID1
    on gen_relation (PID1);

create index PID2
    on gen_relation (PID2);

create index RELATION_TYPE_ID
    on gen_relation (RELATION_TYPE_ID);

create table gen_surname
(
    ID      int unsigned auto_increment
        primary key,
    USER_ID int unsigned not null,
    constraint ID
        unique (ID)
)
    charset = utf8
    row_format = COMPACT;

create index USER_ID
    on gen_surname (USER_ID);

create table gen_surname_lang
(
    ID             int unsigned auto_increment
        primary key,
    MALE_SURNAME   varchar(45) null,
    FEMALE_SURNAME varchar(45) null,
    LANG           char(3)     not null,
    constraint FEMALE_SURNAME
        unique (FEMALE_SURNAME),
    constraint ID
        unique (ID),
    constraint MALE_SURNAME
        unique (MALE_SURNAME)
)
    charset = utf8;

create table gen_user
(
    ID          int unsigned auto_increment
        primary key,
    LOGIN       varchar(45)  default ''                    not null,
    PASSWORD    varchar(45)  default ''                    not null,
    FNAME       varchar(45)                                not null,
    SNAME       varchar(45)                                not null,
    SURNAME     varchar(45)                                not null,
    EMAIL       varchar(100)                               not null,
    CREATE_DATE datetime     default '1970-01-01 00:00:00' not null,
    USER_TYPE   int unsigned                               not null,
    ACTIVE      int unsigned default '1'                   null,
    constraint LOGIN
        unique (LOGIN)
)
    charset = utf8;

create table gen_user_right
(
    ID   int unsigned not null
        primary key,
    NAME varchar(45)  not null
)
    charset = utf8;

