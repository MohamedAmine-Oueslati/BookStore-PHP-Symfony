<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101214900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_book_genre (books_id INT NOT NULL, book_genre_id INT NOT NULL, INDEX IDX_A1150FFC7DD8AC20 (books_id), INDEX IDX_A1150FFC5B69C546 (book_genre_id), PRIMARY KEY(books_id, book_genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE books_book_genre ADD CONSTRAINT FK_A1150FFC7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_book_genre ADD CONSTRAINT FK_A1150FFC5B69C546 FOREIGN KEY (book_genre_id) REFERENCES book_genre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE books_book_genre');
    }
}
