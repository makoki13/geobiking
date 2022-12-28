PGDMP         )                z            foobardb    11.0 (Debian 11.0-1.pgdg90+2)    12.2     I           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            J           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            K           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            L           1262    16385    foobardb    DATABASE     x   CREATE DATABASE foobardb WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.utf8' LC_CTYPE = 'en_US.utf8';
    DROP DATABASE foobardb;
                spawn_admin_cBuT    false            �            1259    24593 
   autonomias    TABLE     c   CREATE TABLE public.autonomias (
    id integer NOT NULL,
    nombre character varying NOT NULL
);
    DROP TABLE public.autonomias;
       public            spawn_admin_cBuT    false            �            1259    24577    localidades    TABLE     �   CREATE TABLE public.localidades (
    id bigint NOT NULL,
    nombre character varying,
    ine character varying,
    provincia integer
);
    DROP TABLE public.localidades;
       public            spawn_admin_cBuT    false            M           0    0    TABLE localidades    COMMENT     A   COMMENT ON TABLE public.localidades IS 'Maestro de localidades';
          public          spawn_admin_cBuT    false    196            �            1259    24585 
   provincias    TABLE     �   CREATE TABLE public.provincias (
    id integer NOT NULL,
    nombre character varying NOT NULL,
    autonomia integer NOT NULL,
    id_geo character varying
);
    DROP TABLE public.provincias;
       public            spawn_admin_cBuT    false            �            1259    24601    puntos    TABLE     �   CREATE TABLE public.puntos (
    id_poblacion bigint NOT NULL,
    punto point,
    lat real NOT NULL,
    lon real NOT NULL
);
    DROP TABLE public.puntos;
       public            spawn_admin_cBuT    false            E          0    24593 
   autonomias 
   TABLE DATA           0   COPY public.autonomias (id, nombre) FROM stdin;
    public          spawn_admin_cBuT    false    198   X       C          0    24577    localidades 
   TABLE DATA           A   COPY public.localidades (id, nombre, ine, provincia) FROM stdin;
    public          spawn_admin_cBuT    false    196   T       D          0    24585 
   provincias 
   TABLE DATA           C   COPY public.provincias (id, nombre, autonomia, id_geo) FROM stdin;
    public          spawn_admin_cBuT    false    197   �       F          0    24601    puntos 
   TABLE DATA           ?   COPY public.puntos (id_poblacion, punto, lat, lon) FROM stdin;
    public          spawn_admin_cBuT    false    199   �       �
           2606    24592    provincias Provincias_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.provincias
    ADD CONSTRAINT "Provincias_pkey" PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.provincias DROP CONSTRAINT "Provincias_pkey";
       public            spawn_admin_cBuT    false    197            �
           2606    24600    autonomias autonomias_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.autonomias
    ADD CONSTRAINT autonomias_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.autonomias DROP CONSTRAINT autonomias_pkey;
       public            spawn_admin_cBuT    false    198            �
           2606    24584    localidades localidades_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.localidades
    ADD CONSTRAINT localidades_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.localidades DROP CONSTRAINT localidades_pkey;
       public            spawn_admin_cBuT    false    196            �
           2606    24613    puntos puntos_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.puntos
    ADD CONSTRAINT puntos_pkey PRIMARY KEY (id_poblacion, lat, lon);
 <   ALTER TABLE ONLY public.puntos DROP CONSTRAINT puntos_pkey;
       public            spawn_admin_cBuT    false    199    199    199            E   �   x�M��NB1��3O��X.�K$jL�&&l~N�)=f�_���΋9e#����ji�b�xDK]���������f'�������S��SzB:��jH.!F�7���o�m0��:r��\	���_{eVЖԽ��m�!��\]E��ZZ-ώ�9Gds��َ�Ỉ?�UQ�6��o�\��N/~��b{~���|*�K+��"mC����>6P�
�kﮙ�ohF      C   8   x�3�4�45�4��9��()5/��Ә�����������7�(17���ӈ+F��� 2��      D   >   x�3�tN,.I��9�9�ӄ�5X�9�ˈ3,1'5/93"�e�阓���W�
q����� D��      F   �  x���Q�,'���_IR��ѽd��Nbɽ3�3��< �C�Q���_�"C?2����*\������D����
}x��u�p�b?���-�|TQ��ߴ�?]i���h����ECڏ�+�(k
���i�Z�ځ�V:E���?h�����M��J���GuZ��	�z�8gy��ݎ͊�\�>A	�wld�x0��֊Ӗ�nZۇG��Fk�&�m�2�V%��uk����6�>?d�A�M�&��	��!!4�J#/���?��$�L�Z<���h�3Z(JS�X��=9F
-��TS
_JE��.�h�����3��֍�|0Îc�Li
�mpjX
�bp�H�mT�JM���ѡ��AC`<Aqv�Ŧ�� �L����)8�mΓ�	|���B�>�U��ns�K��H���)p���M�:5^�=mk�d�r�[N�V ��(��4��9���-pM[!��9hKq���b�BMh���1�#�2�R܍U�A1�n��lvmY���&k�]7�q;2�;
�C�+缇�9գ�(���8G����5����l�#��z�W���'+~�{Ւ��Z�:�mF�;��l���V�'���|-t2:��&nYۉ��p,/�XS��@��f���bM#�f��R���ºh�@ʫ6��)ɉ�ݜ].�c���1���*���7wE��~w�;.{��!��_ a؈�G��X:L`��+H`q5�h���f�g�4��l*�����ҥO=n�ϣ�ijd�;�.ZG���<O�9�vMx�Þ'�����͈j���i�wQJ����7ф�DX�c޹��}�ԝ�F�7Ɯ��N�$����T���y�Z�:fHVl=��w$s��8_���'Z����g#m��*�L�h��i16r�����[�!��_q��߯����c7     