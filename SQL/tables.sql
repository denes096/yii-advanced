CREATE TABLE users (
  user_id integer NOT NULL PRIMARY KEY,
  name varchar(50) NOT NULL,
  email varchar NOT NULL,
  password varchar NOT NULL,
  regtime timestamp,
  lastlogin timestamp,
  isadmin boolean DEFAULT false

);

CREATE TABLE ticket (
    ticket_id integer NOT NULL PRIMARY KEY,
    title text NOT NULL,
    is_open boolean DEFAULT true,
    created timestamp,
    user_id integer REFERENCES  users (user_id),
    admin_id integer REFERENCES users (user_id),
    UNIQUE (ticket_id)
);