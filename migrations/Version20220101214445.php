<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101214445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_genre_books');
        $this->addSql('ALTER TABLE books DROP genre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_genre_books (book_genre_id INT NOT NULL, books_id INT NOT NULL, INDEX IDX_A5EA7A2B5B69C546 (book_genre_id), INDEX IDX_A5EA7A2B7DD8AC20 (books_id), PRIMARY KEY(book_genre_id, books_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE book_genre_books ADD CONSTRAINT FK_A5EA7A2B5B69C546 FOREIGN KEY (book_genre_id) REFERENCES book_genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_genre_books ADD CONSTRAINT FK_A5EA7A2B7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books ADD genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
