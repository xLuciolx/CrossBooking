<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190722183947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friend (id INT AUTO_INCREMENT NOT NULL, action INT NOT NULL, status INT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friend_member (friend_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_A1FF0D116A5458E8 (friend_id), INDEX IDX_A1FF0D117597D3FE (member_id), PRIMARY KEY(friend_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE startpoint (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(100) NOT NULL, summary LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, isbn BIGINT NOT NULL, disponibility TINYINT(1) NOT NULL, language VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, pseudo_capture VARCHAR(50) DEFAULT NULL, INDEX IDX_CBE5A3317597D3FE (member_id), INDEX IDX_CBE5A33112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_author (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_9478D34516A2B381 (book_id), INDEX IDX_9478D345F675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pointer (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, city VARCHAR(150) NOT NULL, date DATETIME NOT NULL, INDEX IDX_320468A816A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE capture (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, pointer_id INT NOT NULL, comment VARCHAR(500) DEFAULT NULL, INDEX IDX_8BFEA6E57597D3FE (member_id), UNIQUE INDEX UNIQ_8BFEA6E51B63EC6C (pointer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, mail VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, avatar VARCHAR(255) NOT NULL, token VARCHAR(40) DEFAULT NULL, created_at DATETIME NOT NULL, roles JSON NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friend_member ADD CONSTRAINT FK_A1FF0D116A5458E8 FOREIGN KEY (friend_id) REFERENCES friend (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE friend_member ADD CONSTRAINT FK_A1FF0D117597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3317597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pointer ADD CONSTRAINT FK_320468A816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE capture ADD CONSTRAINT FK_8BFEA6E57597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE capture ADD CONSTRAINT FK_8BFEA6E51B63EC6C FOREIGN KEY (pointer_id) REFERENCES pointer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D345F675F31B');
        $this->addSql('ALTER TABLE friend_member DROP FOREIGN KEY FK_A1FF0D116A5458E8');
        $this->addSql('ALTER TABLE book_author DROP FOREIGN KEY FK_9478D34516A2B381');
        $this->addSql('ALTER TABLE pointer DROP FOREIGN KEY FK_320468A816A2B381');
        $this->addSql('ALTER TABLE capture DROP FOREIGN KEY FK_8BFEA6E51B63EC6C');
        $this->addSql('ALTER TABLE friend_member DROP FOREIGN KEY FK_A1FF0D117597D3FE');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3317597D3FE');
        $this->addSql('ALTER TABLE capture DROP FOREIGN KEY FK_8BFEA6E57597D3FE');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE friend');
        $this->addSql('DROP TABLE friend_member');
        $this->addSql('DROP TABLE startpoint');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_author');
        $this->addSql('DROP TABLE pointer');
        $this->addSql('DROP TABLE capture');
        $this->addSql('DROP TABLE member');
    }
}
