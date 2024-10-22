CREATE DATABASE nrv_auth;
CREATE DATABASE nrv_party;
CREATE DATABASE nrv_place;
CREATE DATABASE nrv_show;
CREATE DATABASE nrv_ticket;


\connect nrv_auth;

DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
  "id" uuid NOT NULL,
  "email" character varying(128) NOT NULL,
  "password" character varying(256) NOT NULL,
  "role" integer DEFAULT '0' NOT NULL
) WITH (oids = false);

\connect nrv_party;

DROP TABLE IF EXISTS "party";
CREATE TABLE "public"."party" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "theme" character varying(50) NOT NULL,
    "date" timestamp NOT NULL,
    "begin" timestamp NOT NULL,
    "place_id" uuid NOT NULL,
    "show1_id" uuid NOT NULL,
    "show2_id" uuid,
    "show3_id" uuid,
    "price" integer
) WITH (oids = false);


\connect nrv_place
DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
   "id" uuid NOT NULL,
   "path" character varying(256) NOT NULL,
   "place_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "places";
CREATE TABLE "public"."places" (
   "id" uuid NOT NULL,
   "name" character varying(50) NOT NULL,
   "address" character varying(128) NOT NULL,
   "nb_sit" integer NOT NULL,
   "nb_stand" integer NOT NULL
) WITH (oids = false);

\connect nrv_show;

DROP TABLE IF EXISTS "artists";
CREATE TABLE "public"."artists" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "style" character varying(50) NOT NULL,
    "image" character varying(128) DEFAULT 'default.jpg' NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "artists2style";
CREATE TABLE "public"."artists2style" (
    "artist_id" uuid NOT NULL,
    "style_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
    "id" uuid NOT NULL,
    "path" character varying(256) NOT NULL,
    "show_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "perform";
CREATE TABLE "public"."perform" (
    "show_id" uuid NOT NULL,
    "artist_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "shows";
CREATE TABLE "public"."shows" (
    "id" uuid NOT NULL,
    "title" character varying(50) NOT NULL,
    "description" character varying(128) NOT NULL,
    "video" character varying(256),
    "begin" timestamp NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "style";
CREATE TABLE "public"."style" (
  "id" uuid NOT NULL,
  "name" character varying(50) NOT NULL
) WITH (oids = false);

\connect nrv_ticket;
DROP TABLE IF EXISTS "tickets";
CREATE TABLE "public"."tickets" (
    "id" uuid NOT NULL,
    "name" character varying(50) NOT NULL,
    "price" integer NOT NULL,
    "quantity" integer NOT NULL,
    "party_id" uuid NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "soldtickets";
CREATE TABLE "public"."soldtickets" (
      "id" uuid NOT NULL,
      "name" character varying(50) NOT NULL,
      "price" integer NOT NULL,
      "user_id" uuid NOT NULL,
      "ticket_id" uuid NOT NULL,
      "party_id" uuid NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "cards";
CREATE TABLE "public"."cards" (
  "id" uuid NOT NULL,
  "user_id" uuid NOT NULL,
  "total_price" integer NOT NULL
) WITH (oids = false);

DROP TABLE IF EXISTS "card_content";
CREATE TABLE "public"."card_content" (
 "card_id" uuid NOT NULL,
 "ticket_id" uuid NOT NULL,
 "quantity" integer DEFAULT '1' NOT NULL
) WITH (oids = false);