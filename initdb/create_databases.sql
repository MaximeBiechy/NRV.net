CREATE DATABASE nrv_auth;
CREATE DATABASE nrv_party;
CREATE DATABASE nrv_place;
CREATE DATABASE nrv_show;


\connect nrv_auth;

DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
  "id" uuid NOT NULL,
  "email" character(128) NOT NULL,
  "password" character(256) NOT NULL,
  "role" integer DEFAULT '0' NOT NULL
) WITH (oids = false);

\connect nrv_party;

DROP TABLE IF EXISTS "party";
CREATE TABLE "public"."party" (
  "id" uuid NOT NULL,
  "name" character(50) NOT NULL,
  "theme" character(50) NOT NULL,
  "date" timestamp NOT NULL,
  "begin" timestamp NOT NULL,
  "place_id" uuid NOT NULL,
  "show1_id" uuid NOT NULL,
  "show2_id" uuid,
  "show3_id" uuid
) WITH (oids = false);


\connect nrv_place
DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
   "id" uuid NOT NULL,
   "path" character(256) NOT NULL,
   "place_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "places";
CREATE TABLE "public"."places" (
   "id" uuid NOT NULL,
   "name" character(50) NOT NULL,
   "address" character(128) NOT NULL,
   "nbSit" integer NOT NULL,
   "nbStand" integer NOT NULL
) WITH (oids = false);

\connect nrv_show;
DROP TABLE IF EXISTS "artists";
CREATE TABLE "public"."artists" (
    "id" uuid NOT NULL,
    "name" character(50) NOT NULL,
    "style" character(50) NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "images";
CREATE TABLE "public"."images" (
    "id" uuid NOT NULL,
    "path" character(256) NOT NULL,
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
    "title" character(50) NOT NULL,
    "description" character(128) NOT NULL,
    "video" character(256) NOT NULL,
    "begin" timestamp NOT NULL
) WITH (oids = false);