<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124161326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, campain_id INT DEFAULT NULL, emplacement VARCHAR(255) DEFAULT NULL, volume INT DEFAULT NULL, video_url LONGTEXT DEFAULT NULL, button_url VARCHAR(255) DEFAULT NULL, button_text VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_6F9DB8E720B77272 (campain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_verification (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, banner_id INT DEFAULT NULL, video_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_93CD9207B03A8386 (created_by_id), INDEX IDX_93CD9207684EC833 (banner_id), UNIQUE INDEX UNIQ_93CD920729C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_verification_image (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, banner_verification_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_82B49C793DA5256D (image_id), INDEX IDX_82B49C79C5AC85B3 (banner_verification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chatbot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chatbot_campain (chatbot_id INT NOT NULL, campain_id INT NOT NULL, INDEX IDX_E26BA3C41984C580 (chatbot_id), INDEX IDX_E26BA3C420B77272 (campain_id), PRIMARY KEY(chatbot_id, campain_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, content_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, banner_id INT NOT NULL, content_path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C53D045F684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, banner_id INT DEFAULT NULL, content_path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7CC7DA2C684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E720B77272 FOREIGN KEY (campain_id) REFERENCES campain (id)');
        $this->addSql('ALTER TABLE banner_verification ADD CONSTRAINT FK_93CD9207B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE banner_verification ADD CONSTRAINT FK_93CD9207684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
        $this->addSql('ALTER TABLE banner_verification ADD CONSTRAINT FK_93CD920729C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE banner_verification_image ADD CONSTRAINT FK_82B49C793DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE banner_verification_image ADD CONSTRAINT FK_82B49C79C5AC85B3 FOREIGN KEY (banner_verification_id) REFERENCES banner_verification (id)');
        $this->addSql('ALTER TABLE chatbot_campain ADD CONSTRAINT FK_E26BA3C41984C580 FOREIGN KEY (chatbot_id) REFERENCES chatbot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chatbot_campain ADD CONSTRAINT FK_E26BA3C420B77272 FOREIGN KEY (campain_id) REFERENCES campain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E720B77272');
        $this->addSql('ALTER TABLE banner_verification DROP FOREIGN KEY FK_93CD9207B03A8386');
        $this->addSql('ALTER TABLE banner_verification DROP FOREIGN KEY FK_93CD9207684EC833');
        $this->addSql('ALTER TABLE banner_verification DROP FOREIGN KEY FK_93CD920729C1004E');
        $this->addSql('ALTER TABLE banner_verification_image DROP FOREIGN KEY FK_82B49C793DA5256D');
        $this->addSql('ALTER TABLE banner_verification_image DROP FOREIGN KEY FK_82B49C79C5AC85B3');
        $this->addSql('ALTER TABLE chatbot_campain DROP FOREIGN KEY FK_E26BA3C41984C580');
        $this->addSql('ALTER TABLE chatbot_campain DROP FOREIGN KEY FK_E26BA3C420B77272');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F684EC833');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C684EC833');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE banner_verification');
        $this->addSql('DROP TABLE banner_verification_image');
        $this->addSql('DROP TABLE campain');
        $this->addSql('DROP TABLE chatbot');
        $this->addSql('DROP TABLE chatbot_campain');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
