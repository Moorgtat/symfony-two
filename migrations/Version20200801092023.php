<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200801092023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE role_user (role_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(role_id, user_id))');
        $this->addSql('CREATE INDEX IDX_332CA4DDD60322AC ON role_user (role_id)');
        $this->addSql('CREATE INDEX IDX_332CA4DDA76ED395 ON role_user (user_id)');
        $this->addSql('DROP INDEX IDX_C53D045F4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, product_id, url, caption FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, url VARCHAR(255) NOT NULL COLLATE BINARY, caption VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, product_id, url, caption) SELECT id, product_id, url, caption FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F4584665A ON image (product_id)');
        $this->addSql('DROP INDEX IDX_D34A04ADF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, author_id, title, slug, price, introduction, content, cover_image, rooms FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION NOT NULL, introduction CLOB NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, cover_image VARCHAR(255) NOT NULL COLLATE BINARY, rooms INTEGER NOT NULL, CONSTRAINT FK_D34A04ADF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, author_id, title, slug, price, introduction, content, cover_image, rooms) SELECT id, author_id, title, slug, price, introduction, content, cover_image, rooms FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP INDEX IDX_C53D045F4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, product_id, url, caption FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO image (id, product_id, url, caption) SELECT id, product_id, url, caption FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F4584665A ON image (product_id)');
        $this->addSql('DROP INDEX IDX_D34A04ADF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, author_id, title, slug, price, introduction, content, cover_image, rooms FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, introduction CLOB NOT NULL, content CLOB NOT NULL, cover_image VARCHAR(255) NOT NULL, rooms INTEGER NOT NULL)');
        $this->addSql('INSERT INTO product (id, author_id, title, slug, price, introduction, content, cover_image, rooms) SELECT id, author_id, title, slug, price, introduction, content, cover_image, rooms FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADF675F31B ON product (author_id)');
    }
}
