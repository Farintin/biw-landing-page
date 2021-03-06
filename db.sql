PGDMP         &                x            biw-landing-page    12.2    12.2                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16393    biw-landing-page    DATABASE     �   CREATE DATABASE "biw-landing-page" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
 "   DROP DATABASE "biw-landing-page";
                postgres    false            �            1259    16406    event    TABLE     �   CREATE TABLE public.event (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    phone text NOT NULL,
    message text NOT NULL
);
    DROP TABLE public.event;
       public         heap    postgres    false            �            1259    16404    event_id_seq    SEQUENCE     �   ALTER TABLE public.event ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.event_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    203            �            1259    16416    masterclass    TABLE     �   CREATE TABLE public.masterclass (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    address text NOT NULL,
    phone text NOT NULL
);
    DROP TABLE public.masterclass;
       public         heap    postgres    false            �            1259    16414    masterclass_id_seq    SEQUENCE     �   ALTER TABLE public.masterclass ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.masterclass_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    205            �            1259    16423 
   newsletter    TABLE     U   CREATE TABLE public.newsletter (
    id integer NOT NULL,
    email text NOT NULL
);
    DROP TABLE public.newsletter;
       public         heap    postgres    false            �            1259    16421    newsletter_id_seq    SEQUENCE     �   ALTER TABLE public.newsletter ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.newsletter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    207                      0    16406    event 
   TABLE DATA           @   COPY public.event (id, name, email, phone, message) FROM stdin;
    public          postgres    false    203   �                 0    16416    masterclass 
   TABLE DATA           F   COPY public.masterclass (id, name, email, address, phone) FROM stdin;
    public          postgres    false    205   �                 0    16423 
   newsletter 
   TABLE DATA           /   COPY public.newsletter (id, email) FROM stdin;
    public          postgres    false    207   �                  0    0    event_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.event_id_seq', 3, true);
          public          postgres    false    202                       0    0    masterclass_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.masterclass_id_seq', 3, true);
          public          postgres    false    204                        0    0    newsletter_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.newsletter_id_seq', 44, true);
          public          postgres    false    206            �
           2606    16489    event event_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.event DROP CONSTRAINT event_pkey;
       public            postgres    false    203            �
           2606    16450    masterclass masterclass_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.masterclass
    ADD CONSTRAINT masterclass_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.masterclass DROP CONSTRAINT masterclass_pkey;
       public            postgres    false    205            �
           2606    16440    newsletter newsletter_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.newsletter
    ADD CONSTRAINT newsletter_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.newsletter DROP CONSTRAINT newsletter_pkey;
       public            postgres    false    207                  x������ � �            x������ � �            x������ � �     