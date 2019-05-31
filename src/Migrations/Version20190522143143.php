<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190522143143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_BASKEID');
        $this->addSql('DROP TABLE baskets');
        $this->addSql('ALTER TABLE offer DROP discount, DROP datestart, DROP datefinish, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA090B42E');
        $this->addSql('DROP INDEX IDX_D34A04ADA090B42E ON product');
        $this->addSql('DROP INDEX FK_BASKEID_idx ON product');
        $this->addSql('ALTER TABLE product ADD offer_id INT DEFAULT NULL, DROP basket_id, DROP offers_id, DROP unitofferprice');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD53C674EE ON product (offer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE baskets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(85) DEFAULT NULL COLLATE latin1_swedish_ci, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE offer ADD discount INT DEFAULT NULL, ADD datestart DATETIME DEFAULT NULL, ADD datefinish DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD53C674EE');
        $this->addSql('DROP INDEX IDX_D34A04AD53C674EE ON product');
        $this->addSql('ALTER TABLE product ADD offers_id INT DEFAULT NULL, ADD unitofferprice DOUBLE PRECISION DEFAULT NULL, CHANGE offer_id basket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_BASKEID FOREIGN KEY (basket_id) REFERENCES baskets (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA090B42E FOREIGN KEY (offers_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA090B42E ON product (offers_id)');
        $this->addSql('CREATE INDEX FK_BASKEID_idx ON product (basket_id)');
    }
}
