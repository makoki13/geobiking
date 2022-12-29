PGDMP     2                    z            foobardb    11.0 (Debian 11.0-1.pgdg90+2)    15.1     a           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            b           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            c           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            d           1262    16385    foobardb    DATABASE     s   CREATE DATABASE foobardb WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';
    DROP DATABASE foobardb;
                spawn_admin_cBuT    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                spawn_admin_cBuT    false            e           0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   spawn_admin_cBuT    false    6            �            1259    24593 
   autonomias    TABLE     c   CREATE TABLE public.autonomias (
    id integer NOT NULL,
    nombre character varying NOT NULL
);
    DROP TABLE public.autonomias;
       public            spawn_admin_cBuT    false    6            �            1259    24577    localidades    TABLE     �   CREATE TABLE public.localidades (
    id bigint NOT NULL,
    nombre character varying,
    ine character varying,
    provincia integer
);
    DROP TABLE public.localidades;
       public            spawn_admin_cBuT    false    6            f           0    0    TABLE localidades    COMMENT     A   COMMENT ON TABLE public.localidades IS 'Maestro de localidades';
          public          spawn_admin_cBuT    false    196            �            1259    24622    logros    TABLE     �   CREATE TABLE public.logros (
    id integer NOT NULL,
    nombre character varying NOT NULL,
    tipo integer,
    logo bytea,
    comando character varying
);
    DROP TABLE public.logros;
       public            spawn_admin_cBuT    false    6            �            1259    24585 
   provincias    TABLE     �   CREATE TABLE public.provincias (
    id integer NOT NULL,
    nombre character varying NOT NULL,
    autonomia integer NOT NULL,
    id_geo character varying,
    poblaciones integer
);
    DROP TABLE public.provincias;
       public            spawn_admin_cBuT    false    6            �            1259    24601    puntos    TABLE     �   CREATE TABLE public.puntos (
    id_poblacion bigint NOT NULL,
    punto point,
    lat real NOT NULL,
    lon real NOT NULL
);
    DROP TABLE public.puntos;
       public            spawn_admin_cBuT    false    6            �            1259    24614    usuarios    TABLE     �   CREATE TABLE public.usuarios (
    id bigint NOT NULL,
    nombre character varying NOT NULL,
    clave character varying,
    fecha_alta date
);
    DROP TABLE public.usuarios;
       public            spawn_admin_cBuT    false    6            �            1259    24630    usuarios_registro    TABLE     �   CREATE TABLE public.usuarios_registro (
    usuario bigint NOT NULL,
    localidad bigint NOT NULL,
    momento time without time zone DEFAULT now() NOT NULL
);
 %   DROP TABLE public.usuarios_registro;
       public            spawn_admin_cBuT    false    6            Z          0    24593 
   autonomias 
   TABLE DATA           0   COPY public.autonomias (id, nombre) FROM stdin;
    public          spawn_admin_cBuT    false    198   �       X          0    24577    localidades 
   TABLE DATA           A   COPY public.localidades (id, nombre, ine, provincia) FROM stdin;
    public          spawn_admin_cBuT    false    196   �       ]          0    24622    logros 
   TABLE DATA           A   COPY public.logros (id, nombre, tipo, logo, comando) FROM stdin;
    public          spawn_admin_cBuT    false    201          Y          0    24585 
   provincias 
   TABLE DATA           P   COPY public.provincias (id, nombre, autonomia, id_geo, poblaciones) FROM stdin;
    public          spawn_admin_cBuT    false    197   5       [          0    24601    puntos 
   TABLE DATA           ?   COPY public.puntos (id_poblacion, punto, lat, lon) FROM stdin;
    public          spawn_admin_cBuT    false    199   �!       \          0    24614    usuarios 
   TABLE DATA           A   COPY public.usuarios (id, nombre, clave, fecha_alta) FROM stdin;
    public          spawn_admin_cBuT    false    200   �:       ^          0    24630    usuarios_registro 
   TABLE DATA           H   COPY public.usuarios_registro (usuario, localidad, momento) FROM stdin;
    public          spawn_admin_cBuT    false    202   ;       �
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
           2606    24629    logros logros_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.logros
    ADD CONSTRAINT logros_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.logros DROP CONSTRAINT logros_pkey;
       public            spawn_admin_cBuT    false    201            �
           2606    24613    puntos puntos_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.puntos
    ADD CONSTRAINT puntos_pkey PRIMARY KEY (id_poblacion, lat, lon);
 <   ALTER TABLE ONLY public.puntos DROP CONSTRAINT puntos_pkey;
       public            spawn_admin_cBuT    false    199    199    199            �
           2606    24621    usuarios usuarios_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            spawn_admin_cBuT    false    200            �
           2606    24635 (   usuarios_registro usuarios_registro_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY public.usuarios_registro
    ADD CONSTRAINT usuarios_registro_pkey PRIMARY KEY (usuario, localidad);
 R   ALTER TABLE ONLY public.usuarios_registro DROP CONSTRAINT usuarios_registro_pkey;
       public            spawn_admin_cBuT    false    202    202            Z   �   x�M��NB1��3O��X.�K$jL�&&l~N�)=f�_���΋9e#����ji�b�xDK]���������f'�������S��SzB:��jH.!F�7���o�m0��:r��\	���_{eVЖԽ��m�!��\]E��ZZ-ώ�9Gds��َ�Ỉ?�UQ�6��o�\��N/~��b{~���|*�K+��"mC����>6P�
�kﮙ�ohF      X   _   x�3�47�4630���,J�M,��4�2�47765�4�t/M,J	+��*�$*'��ÔX�Z�q�$f��U417746�tO�K�L���qqq HG|      ]      x������ � �      Y     x�M�Mn�0��3���B��H-�H[�iPY�L,�PBKey�]��tQ��X��ld'|"g޼7PQpޏo-h���P�A�5�<	<�A.0�k�D[wpPFd��.�	DD"Sh�ޱ�E$R[�pC5=w'�;�*r,�yG��W�������
�"�a�|�LP	�B��v]��*�HB5�n�+K������)I�9
���-%�RYn�pi %W+�6P�J�Y�F������3��ukQ
��{8�t�=�I�28�������bB2�(��n�%�@*���R��N��(5|#צz�A���Ř��l�,`�]S��P��h�g�Z,���Lba9�:�g�e	+�CSC�Ĕ�2X!*��sJ��@���tS�J��!��w�ZɈ�Chb�:BcQi�?�:)�@�G��>���NYjT�w<����+�������bv)���Y��UN�On�q��/���\���O!�z��:���uǳ���3^W����u.��B�`]�]6FX�Z�������9l:��n^���1sOu����Y��2pӜ^��WHVh�'������Q�|��Q�0ϠrÁ�Ԇ����i�Q5CM��#��D8�j|u�4�l��Pua���\ϱr	�������~����(;d      [      x��]Y�$���>�d&�%;�E�?� "
�����Ʀ����N@�V|�ǿB��%������?.��N�/������1��V��O�������ll�����{��k�&;[T\nru�;��3eB�V���4����0�yV��ig�y��Y��|�k;"�lI������a�|�.
�[Zc`�Ӓ��S�"�lym^�ؒ�
��]:��%lg�l��u˥N�������'�9=���k8�H�Z��-���O��9 � ��^��)��ف�L¦%O6ǅb@AT��A���Ru�{Y�����
6#�M؂�4�nA�l�zl�i�ck�
lP�Os�X[���;#5���N%)�l�V\;bخ�m��sf�P�͓�%:�nO�(�[q/d~ia�z�ƚ��֍���^2Q���-u���Q[�V�F��6*30Ѥŭ6aUp)�Mj��؄-8X[�"U�Fİ�n�)[�j�"a�'���͘���bW��l�/`[�a�{�����s����2[�F������c�p�(��l/w�J�l"�!C�J~�5�(ڨ����^���׃�W��WŸ
ic>��g�6���gZ{ vhP�ѡ��|dyM��yzg�������bV�5�{�}�#+��@T�N*\�x��W�C)_��m)g��G܊�h�v#��B��c�I�G '|ǚ�pҹ�6���B��M�<B/���C(u�M0�([��~���.(KG��:R�T.q��Z�]��֮iΑ��S|���9��"�gZsBt���e�I"؉ lK���aKc�Q�Ⱦ�F���d��5�u	�x�uO*���[XM慭"H��M�T�{1c���g�f&�1�J�T�	+|{�U� 2���º[EZl�`3]��fa�cNa�Ԕ��,/l��<��i���ֳ�L�,%���&	7�iOq3~H�F�bl�{�,�L4���#�
��Y/r6�XC�����+��K��͵W6��[@��̖�A#�{d��ȦSUa3���
U*dY�fh�ɸ�X6�"�\v��B�{�^�,��B،��(�<\�f�i9�<������O�T�G�9/��e�L������nĮ���-k��L�k4�v!�u/�{0����Yw
��XT9��4>�TBt�ۍ �q�/���Ih��N�h�J����ۥ�My�iuz��佳�=�~��v�5�(d,/N����g�.ܰE��nw�=�5�&l��������蘒���:�#v&��a�)[Ga���N�ɚ�M�6Ǌ�J��.���c���+|�`㖵�tۙ<Z(�:`'R��zY�x�����%�o"+��h��au��c3%���x[��cӊE�[FU�F���B�D꣬��yP�%V1����U��b"��J{a�(��m�رlR��VQ���r�=������'�Ʀ� he��d,K����X5�B�;�R�Ŧ7A\S�#�P"�Y��,�	�[s26�%�^�߈nZlb~�o��*C� n�;��fZxbSu-d�[���j@�LoľnU0�f�߲��+�}ͪ�|�ds$a�k6��n-�RL��lMkV��a���)���fu!K���S}�E9�)j�f�k���F얍�w��ЪZ"�7�F��	:gz#v��U�،O��&ӞM�̆W���&�6I,���bS#�����&f;_��.�z�QX��٢�5��nĮ�M���H�7B1�Xx�����tw9 �i�[��W`CF��Ke�������F�6��b`]�j�إ�)�o��Yd�A�;�r 0�������խ�L6{P,�_%��dɴ���s6���&=e�*�͖O�`�h�Dv{A皕�0�6-�-���Ep ���e����,N�VE�n�>S]��V�S�ͭ���v6�|�$Ӯ]D�B�e�i'K�{�5g<������;�6�ck��t@]>Q�Xʰy�ndf���X�2���i��{�3�Wl9#\id������FCAT$���l���d�y�U��V��ln������]�:z��Ճ������ȍ�ͫ�E��Y��N{{#�n��!�i�L��n6dr7���P�f�f�ʺ�i;��OgY=�c�o�����BP%PkT'�([��):�li^q&���S2��/'��n���a+������C�B�%�����p*k�&[`�h4
�/�>Z,`�}0�Z��-���㜘���yX�+8%3�1�P����}�:���Ȳ�u�ݕ��*��.������~N����<ɴ0a�Μ�VvC���
˦K�SĬ�����d���'�l*�����5tl*l���Uо�4����L�nJ��ˈ-�)b7bg+^�'�7�H����i�j�0�`J�0?%�2��ؖR����"�w�6&��)�9���{�Y�Jw�.�ϩ�̄hk`z���dMUg1M�uB<t:��O��8�Ct��x�n�BI'��m[[Y�P�O9�D���M2r���6��ur�[����:�5�؄�����09�8�5�F��,�6��bK�"���:��ղ����F&�1ki�:;vim����[���P�7���b�$�a��V(�$N��n���+���9U�F�O�r�"�Ml�=%�B
���8��$?$��(b��ie��md�u�䬵�+��%��700��֌w��dW���L;���.��vh��ԉ lZ���IClGBl����tY����%��LG�QȈ���|w�i��� ɞ�r@g/�D8¦�i{a��M�.^�&���<�/���^��v}��b�}�)�7b��+��k�P���̀�M���\Ds�
��B��3�}}Y��l��B����_G���-�+�/�+R8E^����t��4i4����0Z���g�V�L�����M [�p,Y�
-k}%Ȃ�Q	��L�vt$pd�jy�[妯	+�\�|(ĮIAGyS>�M���E��HC)>�dj����B�zŖ�z�L�->4}67�h�һ ;*��F��)��lCd��"l'R�AT^���lS11 :�n��u=V!�܄Y5t@�nQyՒ�jKwEZDG2�@tT�&���"=4���uN/PV!°�[�W3���0�``l^��Y6ey�%^=��F�-8	7�Z��}j6e�$d{S3���F������Y��[,"��:���My�6VP�)���*?d��.Z[F�p�a����h6�!�m dm��ߚ�QNseL-2��gw�@ᒥ�?�ri��S,֦ad97�\UB2���UK5�8HE�ư^7b_���{��� �H0��dn�m���]��@�U���UO!��f=ݢA�o�>Ӣ3�I�� Nc{7c��)����_]}Ɩ-olSͬ壌��<oĶ5nESm���#3���$!3C��ḥ���	���w3qck��G�<;�P�2oľ	MGks�کEWB����S#�Ѵ������
���C}�q���5/��0��BN���\c`Sh�E��C3�pGlL��0�\k��b\��0�E&��iش�t,���4IGH���W���(	 B����3�0[;PY��������=Y��A���%�S\�`�Ȅ;b��=Pw��\���.N���إ̍[V-{�c|�ȆG�o"�8��v�s�.�������|ݔ����+�����L8��M�����'1v`s���~�Ɖ���#g�AG�d^]��-ٚE�@u<�0�NL7+[��0[6�ytDTʏv{M�d,Y�.v�?�n?\�|(Į�^�� ��
ap�q~��,�C�Y1���@�V$�l:r��(��G�	
5ƶm<�"Z>c���6��P��U�w6u�#ީ�7>D�b�Vm�H������ ���\���u�����A�������G,�C48����ǖI
;.�����TY-[���Rs-=�nu;�hY��牥�V��2�]6ʹW�Jf'l�q�[.g���~K������:��@�r�e�r[�n@��0�������T�a#/��- 	  1Q3� ��
]��L�n����)xIT!�;�D��ñE�~#r	sR�d�� ��D���.���LF+�$��򢳐��/#9`�\=?;�:�
ט������9ጴ�d^�C�J܈]��ت�J����Dզ�by�)ݧ��ؚ�!���f�n�������Ԭ��s'�u.�ts�t�[.u�	賂e|l��Z�[�:Zqَ�X���<U��,�v�鑖UK��^nw���=-b�"�Q���y�7dƔ12�K�	�E�����7.d<�"c�̖LnA|��i�6IQ~�f�$e�f�6����+�R�Ŧ���6��i��(J/D�Up�Ϩ�Q�6"�e�Qm�HY��OD�z�oDkDo<���s*��AT���6��a㚣�4'on��me]�b�G�=u��^�Q&�_��]����LS6�@4ۃQinI�]eOˋ��lz���I��LՆ�I��O�XJh���6=Q��K�����.Y�=4~`��D���U
�P�%(����Y�8W:��@S�V�� �^h�iۇZ�c&�#q�1ۦuȊv+j��� �!�����oق�7��k+w v�E�b�T���aiQ�C=*�E�QO�����+�Z���6�����M �Ȋ�Ҷ�A�{�^��+�� \�ܴ3�N�Y7@�(c ��F��b��e.j�j��`�;tUO��}��2���-2�/� 6����]��݃�y����ʱs��L2��lO;�U[�O� Y��
���52)����-�hD�����)c�\�t}�j.[�X��,���֮vAel����Ǝ�,.���?�Ը�� 	���K��Q�������s4m��U�<��f��#c��~��z�,�<]�6MV+c�>���3�&�2��A3��=h���X7�eZ�C���ў���f���ўe��{�R�Bx"���B$�RVq�,�?C��hD?��M$'�qK١8�]=ǖM��q���U����')v��t�yJ���
]��3��1�C�N��=�ա��L+�[k�oMS=J3� �ԡ��|�6T�����錎�z����\�`�E���Ƶ� �����E�����Jx|#�əs��+�"#��������#�s���9�nk�
UH���[����۰e*��m�4?���s��m�-���̶������ے����u�^���V_�Fٸ�(�'	Q�TolrR�;��RlL�{�i|��m�f?�5��M�K��QI�l7c�<�}`c��a����T���6v۲����M���ю���i	��Ə����J��R%�`��oB=a���?d��+�пd�3͔�d٬W=��фg6��`3	F�l'�S}a����P>��� ��z|a[c{cK.��m���A�3�r0�h>���ul*�{c��u����Q�j�o�Q_���w�~�F�԰q=U/D�72T[E�͸&�q�����B&���ȸK�dry�l{H>GG]B�����VR�L�ܨ�䎔%q�t�c��G��W\z�! ����]�2d�'��ߢ��%>��G���[H|���,
[D�;�r���M	�X��yA=�h�e��d���6~�+
A�M�W t�g�2Ӵ���,�o� c��@h@ӡdl��Q�L��Uf�� ���Ϛ��u�dr���ƷA��k�]���B��
��gY��P�H6��upH�m���`����Wԗ]�ru$ʃ�d�I*��E�|���EK_-JK��E�l��Ŷ�������Q>x"sh%�¦b��U�4���ɲ~Ձ��w���`�S=��D�K�e@��W	���?V	�c���ۻ��6�=�,�zY��"h�w���b���҈'6�fS�VH#��Ж��m�Ϳ�-O�Ȧ`Tش�;aC�D�]����Ǳ��>�M�V~aK��mw>�ٲ{]7u�S�����>�C�#����l�;`�e!qh0ŗ%���ح�y��`O�(�$b��._�9�9�iB&]��ɏ*X2]��H�l|�M|8�H:)�H�WB ��G1��H�%�]�Xvፗo�L�Gx�w�p��
7��ć*�)�
�Q����Lo)��ȱ��d\�-7�~AՐe}R�&'y5??e'����mOL� b_?�i����)ɜ���������H��U�
ܔ��[�N;�;�.#�)&��� ��-6YS?�2�4�|����w�1?�-YM�8����n�'K�x���l�jYv�gs@ԎK�LZ����l�
��V4{ޱє�D�#�\�}fS�X�-!�{fS���	Z[���z�`S"�_�&�7��������3ZN      \      x������ � �      ^   Q   x�%��	�0ѳU����%�ב����	g��2���ޡ$EBT0*|�j ���2�I������VSܨ��<[D^�bq     