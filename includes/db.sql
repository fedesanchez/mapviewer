
CREATE TABLE app.maps
(
  id integer NOT NULL DEFAULT nextval('app.maps_id_seq1'::regclass),
  map text,
  description text,
  created timestamp with time zone,
  modified timestamp with time zone,
  CONSTRAINT maps_pkey1 PRIMARY KEY (id )
)
WITH (
  OIDS=FALSE
);
ALTER TABLE app.maps
  OWNER TO postgres;
