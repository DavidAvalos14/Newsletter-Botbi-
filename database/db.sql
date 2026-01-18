CREATE TABLE "suscriptores" (
    "id_subs" BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    "subs_email" VARCHAR(255) UNIQUE NOT NULL,
    "subs_password" VARCHAR(255) NOT NULL
);

CREATE TABLE "mercados" (
    "id_mercados" BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    "mcds_nombre" VARCHAR(255) UNIQUE NOT NULL,
    "mcds_precio" DECIMAL(12, 2) NOT NULL,
    "mcds_imagen" TEXT NOT NULL,
    "mcds_tipo" VARCHAR(20) NOT NULL CHECK ("mcds_tipo" IN ('Cripto', 'Accion'))
);

CREATE TABLE "noticias" (
    "news_uuid" UUID PRIMARY KEY DEFAULT gen_random_uuid(), -- Autogenerado
    "news_titulo" VARCHAR(255) UNIQUE NOT NULL,
    "news_contenido" TEXT NOT NULL,
    "news_fecha" TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "news_categoria" VARCHAR(50) NOT NULL CHECK ("news_categoria" IN ('Tecnologia', 'Negocios')),
    "news_url" TEXT UNIQUE NOT NULL 
);