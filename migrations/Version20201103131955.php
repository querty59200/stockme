<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103131955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE luggage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, available TINYINT(1) NOT NULL, price DOUBLE PRECISION NOT NULL, height DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_luggage (option_id INT NOT NULL, luggage_id INT NOT NULL, INDEX IDX_41F3DFAFA7C41D6F (option_id), INDEX IDX_41F3DFAF7B18BD6A (luggage_id), PRIMARY KEY(option_id, luggage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, luggage_id INT DEFAULT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_14B784187B18BD6A (luggage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, luggage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4D707F77B18BD6A (luggage_id), INDEX IDX_A4D707F7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_luggage ADD CONSTRAINT FK_41F3DFAFA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_luggage ADD CONSTRAINT FK_41F3DFAF7B18BD6A FOREIGN KEY (luggage_id) REFERENCES luggage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187B18BD6A FOREIGN KEY (luggage_id) REFERENCES luggage (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F77B18BD6A FOREIGN KEY (luggage_id) REFERENCES luggage (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_luggage DROP FOREIGN KEY FK_41F3DFAF7B18BD6A');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187B18BD6A');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F77B18BD6A');
        $this->addSql('ALTER TABLE option_luggage DROP FOREIGN KEY FK_41F3DFAFA7C41D6F');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7A76ED395');
        $this->addSql('DROP TABLE luggage');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_luggage');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE user');
    }
}
