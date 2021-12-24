<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211224212734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_purchased (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, purchase_history_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_3B19A27F16A2B381 (book_id), INDEX IDX_3B19A27F1236D398 (purchase_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, order_placed DATETIME NOT NULL, INDEX IDX_3C60BA32A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_purchased ADD CONSTRAINT FK_3B19A27F16A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE book_purchased ADD CONSTRAINT FK_3B19A27F1236D398 FOREIGN KEY (purchase_history_id) REFERENCES purchase_history (id)');
        $this->addSql('ALTER TABLE purchase_history ADD CONSTRAINT FK_3C60BA32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_purchased DROP FOREIGN KEY FK_3B19A27F1236D398');
        $this->addSql('DROP TABLE book_purchased');
        $this->addSql('DROP TABLE purchase_history');
    }
}
