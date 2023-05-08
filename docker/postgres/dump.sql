DROP TABLE IF EXISTS public.sensor_readings;

CREATE TABLE public.sensor_readings (
    id bigserial NOT NULL,
    sensor_id int8 NOT NULL,
    value float NOT NULL,
    created_at timestamptz NOT NULL DEFAULT now(),
    status varchar NOT NULL DEFAULT 'OK'::character varying
);
CREATE INDEX sensor_readings_created_at_idx ON public.sensor_readings USING btree (created_at);
CREATE INDEX sensor_readings_sensor_id_idx ON public.sensor_readings USING btree (sensor_id);

DROP TABLE IF EXISTS public.sensors;

CREATE TABLE public.sensors (
    id bigserial NOT NULL,
    "name" varchar NOT NULL,
    created_at timestamptz NOT NULL DEFAULT now(),
    status varchar NOT NULL DEFAULT 'ACTIVE'::character varying
);
CREATE UNIQUE INDEX sensors_name_idx ON public.sensors USING btree (name);