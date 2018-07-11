CREATE TABLE Movie(
  id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  year INT NOT NULL,
  rating VARCHAR(10),
  company VARCHAR(50),  /*Movie id is unique to each entry/movie */
	CHECK (year BETWEEN 1000 AND 2018),
	PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE Actor(
		id INT NOT NULL,
		last VARCHAR(20) NOT NULL,
		first VARCHAR(20) NOT NULL,
		sex VARCHAR(6) NOT NULL,
		dob DATE NOT NULL,
		dod DATE,
		PRIMARY KEY(id),
		CHECK (id>0 AND id<=MaxPersonID(id))
)ENGINE = InnoDB;

CREATE TABLE Director(
  id INT NOT NULL,
  last VARCHAR(20),
  first VARCHAR(20),
  dob DATE NOT NULL,
  dod DATE,
	CHECK (dob <= CURDATE()),
	PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE MovieGenre(
		mid INT NOT NULL,
		genre VARCHAR(20),
		FOREIGN KEY (mid) REFERENCES Movie(id)

)ENGINE = InnoDB;

CREATE TABLE MovieDirector(
  mid INT NOT NULL,
  did INT NOT NULL,
	FOREIGN KEY(mid) REFERENCES Movie(id),
	FOREIGN KEY(did) REFERENCES Director(id)
)ENGINE = InnoDB;;

CREATE TABLE MovieActor(
		mid INT NOT NULL,
		aid INT NOT NULL,
		role VARCHAR(50),
		FOREIGN KEY (mid) REFERENCES Movie(id),
		FOREIGN KEY (aid) REFERENCES Actor(id)
)ENGINE = InnoDB;

CREATE TABLE Review(
  name VARCHAR(20),
  time TIMESTAMP NOT NULL,
  mid INT NOT NULL,
  rating INT,
  comment VARCHAR(500),
	FOREIGN KEY(mid) REFERENCES Movie(id)
)ENGINE = InnoDB;

CREATE TABLE MaxPersonID(
  id INT NOT NULL
);

CREATE TABLE MaxMovieID(
  id INT NOT NULL
);
