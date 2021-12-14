<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211211162901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F86383B10');
        $this->addSql('DROP INDEX UNIQ_8157AA0F86383B10 ON profile');
        $this->addSql('ALTER TABLE profile CHANGE avatar_id user_avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F86D8B6F4 FOREIGN KEY (user_avatar_id) REFERENCES avatar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F86D8B6F4 ON profile (user_avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F86D8B6F4');
        $this->addSql('DROP INDEX UNIQ_8157AA0F86D8B6F4 ON profile');
        $this->addSql('ALTER TABLE profile CHANGE user_avatar_id avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F86383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0F86383B10 ON profile (avatar_id)');
    }
}
