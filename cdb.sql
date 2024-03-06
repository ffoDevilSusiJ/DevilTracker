--
-- PostgreSQL database dump
--

-- Dumped from database version 14.11 (Ubuntu 14.11-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.11 (Ubuntu 14.11-0ubuntu0.22.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: add_project_user(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.add_project_user() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    INSERT INTO projects_users (user_id, project_id, role_id)
    VALUES (NEW.owner_id, NEW.id, 1);

    RETURN NEW;
END;
$$;


--
-- Name: p_add_user(character varying, character varying, character varying); Type: PROCEDURE; Schema: public; Owner: -
--

CREATE PROCEDURE public.p_add_user(IN p_username character varying, IN p_password character varying, IN p_email character varying)
    LANGUAGE plpgsql
    AS $$
DECLARE
    salt VARCHAR := gen_salt('bf');
    hashed_password VARCHAR;
BEGIN
    hashed_password := crypt(p_password, 'bf');

    -- Вставка данных в таблицу public.user
    INSERT INTO "user" (username, password, email)
    VALUES (p_username, hashed_password, p_email);

    -- Вывод информации (можете изменить или добавить свой вывод)
    RAISE NOTICE 'user added successfully with hashed password: %', hashed_password;
END;
$$;


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: invites; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.invites (
    token character varying(255) NOT NULL,
    user_id integer NOT NULL,
    status boolean DEFAULT false NOT NULL,
    project_id character varying(255) NOT NULL,
    role_id integer NOT NULL,
    expires_at timestamp with time zone NOT NULL
);


--
-- Name: invites_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.invites_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: invites_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.invites_id_seq OWNED BY public.invites.token;


--
-- Name: invites_role_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.invites_role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: invites_role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.invites_role_id_seq OWNED BY public.invites.role_id;


--
-- Name: invites_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.invites_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: invites_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.invites_user_id_seq OWNED BY public.invites.user_id;


--
-- Name: priority; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.priority (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


--
-- Name: priority_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.priority_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: priority_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.priority_id_seq OWNED BY public.priority.id;


--
-- Name: project; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.project (
    id character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    owner_id integer NOT NULL,
    updated_at date,
    created_at date
);


--
-- Name: project_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.project_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.project_id_seq OWNED BY public.project.id;


--
-- Name: projects_users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.projects_users (
    project_id character varying(255) NOT NULL,
    user_id integer NOT NULL,
    role_id integer
);


--
-- Name: role; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.role (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


--
-- Name: role_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.role_id_seq OWNED BY public.role.id;


--
-- Name: task; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.task (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    creator_id integer,
    executor_id integer,
    priority_id integer,
    deadline_date timestamp with time zone,
    created_at timestamp with time zone NOT NULL,
    completed_at timestamp with time zone,
    project_id character varying(255),
    group_id integer,
    updated_at timestamp with time zone,
    time_spent bigint DEFAULT 0 NOT NULL
);


--
-- Name: task_group; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.task_group (
    id integer NOT NULL,
    title character varying(255) NOT NULL
);


--
-- Name: task_group_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.task_group_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: task_group_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.task_group_id_seq OWNED BY public.task_group.id;


--
-- Name: task_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.task_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: task_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.task_id_seq OWNED BY public.task.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    updated_at date,
    created_at date,
    avatar_path character varying DEFAULT '/storage/app/public/avatars/default.png'::character varying,
    active boolean DEFAULT false
);


--
-- Name: user_confirmation; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.user_confirmation (
    token character varying NOT NULL,
    user_id bigint NOT NULL,
    status boolean DEFAULT false NOT NULL,
    expires_at timestamp with time zone NOT NULL
);


--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: invites token; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites ALTER COLUMN token SET DEFAULT nextval('public.invites_id_seq'::regclass);


--
-- Name: invites user_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites ALTER COLUMN user_id SET DEFAULT nextval('public.invites_user_id_seq'::regclass);


--
-- Name: invites role_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites ALTER COLUMN role_id SET DEFAULT nextval('public.invites_role_id_seq'::regclass);


--
-- Name: priority id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.priority ALTER COLUMN id SET DEFAULT nextval('public.priority_id_seq'::regclass);


--
-- Name: project id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.project ALTER COLUMN id SET DEFAULT nextval('public.project_id_seq'::regclass);


--
-- Name: role id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role ALTER COLUMN id SET DEFAULT nextval('public.role_id_seq'::regclass);


--
-- Name: task id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task ALTER COLUMN id SET DEFAULT nextval('public.task_id_seq'::regclass);


--
-- Name: task_group id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task_group ALTER COLUMN id SET DEFAULT nextval('public.task_group_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: invites; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.invites (token, user_id, status, project_id, role_id, expires_at) FROM stdin;
\.


--
-- Data for Name: priority; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.priority (id, name) FROM stdin;
2	Medium
1	Low
3	High
\.


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.project (id, title, description, owner_id, updated_at, created_at) FROM stdin;
RfTgfV8x7H2MVjnL1WzzwpepO8j7rv	Тестовый проект	Описание проекта	28	2024-03-03	2024-03-03
tyKA0LkAMYEAtAmSnxgUSGsSZzc7zn	Другой проект	С другим описанием	28	2024-03-03	2024-03-03
\.


--
-- Data for Name: projects_users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.projects_users (project_id, user_id, role_id) FROM stdin;
RfTgfV8x7H2MVjnL1WzzwpepO8j7rv	28	1
tyKA0LkAMYEAtAmSnxgUSGsSZzc7zn	28	1
RfTgfV8x7H2MVjnL1WzzwpepO8j7rv	29	3
\.


--
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.role (id, name) FROM stdin;
1	Админ
2	Менеджер
3	Исполнитель
\.


--
-- Data for Name: task; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.task (id, title, description, creator_id, executor_id, priority_id, deadline_date, created_at, completed_at, project_id, group_id, updated_at, time_spent) FROM stdin;
49	df	ef1w	28	29	3	\N	2024-03-06 14:37:25+03	\N	RfTgfV8x7H2MVjnL1WzzwpepO8j7rv	1	2024-03-06 16:21:52+03	5
44	Написать игровой движок	Нужно написать собственный игровой движок1	28	28	3	\N	2024-03-03 21:32:25+03	2024-03-06 19:13:02.114+03	RfTgfV8x7H2MVjnL1WzzwpepO8j7rv	2	2024-03-06 16:13:02+03	277
\.


--
-- Data for Name: task_group; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.task_group (id, title) FROM stdin;
0	Нужно сделать
1	В процессе
2	Сделано
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public."user" (id, username, password, email, updated_at, created_at, avatar_path, active) FROM stdin;
12	valerix	$2y$12$iEjnKCaTOZhNCqUXJJcR2uc2ZJUwPSpKGGVPuJhH.4xX5LdNtyrcq	ffodevilsusij1@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
13	vorlov	$2y$12$MwvaBIU3G1DsC1UYX9JRd.Ovr326YJdYAKbAgjvW3HZ1zIfz1DZrO	ffodevilsusij3@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
14	vorvor	$2y$12$S4LfC1B0PgRpyJUeRb/kX.ACtfyrzEoIx14FwKYGvW6Dy4LvcQsme	ffodevilsusij55@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
15	vorlas	$2y$12$SQO0jB6sI.tG4OnELx41R.PeskxPEj1/PF139.vZi8Wz7722Qv.wq	ffodevilsusij44@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
16	Forlok	$2y$12$aqRlmGYya.5K3s.tKPpS9.UlbL0kHIlAk0qf98n8allIa24VlsORK	devilsusij@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
17	Vago	$2y$12$0PUpvAGNFOpeBmG8JW4M5esTAC/TyY9IGoSUyEI6OoPiTukMcdmKe	ffodevilfsusij@gmail.com	2024-02-24	2024-02-24	/storage/avatars/default.png	t
28	Валерий Орлов	$2y$12$MotmbiZgXPvPUM90aq.r/eHk.zxixltj6c2BnFMOS2QcKXqeFDdrO	ffodevilsusij@gmail.com	2024-03-03	2024-03-03	/storage/app/public/avatars/default.png	t
29	Валерий	$2y$12$RTgsLEzGwfJvRenqdRuo3uuKRe0zws.eHG9GE7yNs9q8MNetkIKT6	rusikbudettut@gmail.com	2024-03-06	2024-03-06	/storage/app/public/avatars/default.png	t
\.


--
-- Data for Name: user_confirmation; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.user_confirmation (token, user_id, status, expires_at) FROM stdin;
f6U5L7hqtHEabhmps39MxTtBPS7LPckNcDN8SOOGvKI5erRNqWKewDY2f5Np	28	t	2024-03-04 15:27:55+03
pw2d9jcb9YJAlmPmeTUbZ3UfhTpJ8JScG8lqcw66WM0cV5NAKo7ckbg3G0Ch	29	t	2024-03-07 12:13:45+03
\.


--
-- Name: invites_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.invites_id_seq', 1, false);


--
-- Name: invites_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.invites_role_id_seq', 1, false);


--
-- Name: invites_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.invites_user_id_seq', 1, false);


--
-- Name: priority_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.priority_id_seq', 10, true);


--
-- Name: project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.project_id_seq', 10, true);


--
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.role_id_seq', 10, true);


--
-- Name: task_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.task_group_id_seq', 10, true);


--
-- Name: task_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.task_id_seq', 54, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.user_id_seq', 29, true);


--
-- Name: invites invites_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites
    ADD CONSTRAINT invites_pk PRIMARY KEY (token);


--
-- Name: priority priority_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.priority
    ADD CONSTRAINT priority_pkey PRIMARY KEY (id);


--
-- Name: project project_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_pkey PRIMARY KEY (id);


--
-- Name: role role_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id);


--
-- Name: task_group task_group_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task_group
    ADD CONSTRAINT task_group_pkey PRIMARY KEY (id);


--
-- Name: task task_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_pkey PRIMARY KEY (id);


--
-- Name: user_confirmation user_confirmation_pk; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.user_confirmation
    ADD CONSTRAINT user_confirmation_pk PRIMARY KEY (token);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: projects_users users_projects_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.projects_users
    ADD CONSTRAINT users_projects_pkey PRIMARY KEY (project_id, user_id);


--
-- Name: project trigger_add_project_user; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER trigger_add_project_user AFTER INSERT ON public.project FOR EACH ROW EXECUTE FUNCTION public.add_project_user();


--
-- Name: invites invites_project_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites
    ADD CONSTRAINT invites_project_fk FOREIGN KEY (project_id) REFERENCES public.project(id) ON DELETE CASCADE;


--
-- Name: invites invites_role_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites
    ADD CONSTRAINT invites_role_fk FOREIGN KEY (role_id) REFERENCES public.role(id) ON DELETE CASCADE;


--
-- Name: invites invites_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.invites
    ADD CONSTRAINT invites_user_fk FOREIGN KEY (user_id) REFERENCES public."user"(id);


--
-- Name: project project_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_owner_id_fkey FOREIGN KEY (owner_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- Name: projects_users projects_users_project_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.projects_users
    ADD CONSTRAINT projects_users_project_fk FOREIGN KEY (project_id) REFERENCES public.project(id) ON DELETE CASCADE;


--
-- Name: task task_creator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_creator_id_fkey FOREIGN KEY (creator_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- Name: task task_executor_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_executor_id_fkey FOREIGN KEY (executor_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- Name: task task_group_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_group_id_fkey FOREIGN KEY (group_id) REFERENCES public.task_group(id) ON DELETE SET NULL;


--
-- Name: task task_priority_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_priority_id_fkey FOREIGN KEY (priority_id) REFERENCES public.priority(id) ON DELETE CASCADE;


--
-- Name: task task_project_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.task
    ADD CONSTRAINT task_project_fk FOREIGN KEY (project_id) REFERENCES public.project(id) ON DELETE CASCADE;


--
-- Name: user_confirmation user_confirmation_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.user_confirmation
    ADD CONSTRAINT user_confirmation_user_fk FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- Name: projects_users users_projects_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.projects_users
    ADD CONSTRAINT users_projects_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.role(id) ON DELETE CASCADE;


--
-- Name: projects_users users_projects_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.projects_users
    ADD CONSTRAINT users_projects_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

