# Php / Design Patterns

## Principes SOLID

### Application du principe Open / Closed

Le principe Open / Closed stipule qu'un objet doit gérer lui-même ses changements d'états, sans le déléguer à une classes externe.

<table>
<tr>
<th>Exemple :</th>
<th>Devient : </th>
</tr>
<tr>
<td>
```php
class Character
{
    private int $currentHealth;

    public function __construct(
        private int $maxHealth
    ) {
        $this->setCurrentHealth($this->maxHealth);
    }

    public function getCurrentHealth() : int
    {
        return $this->currentHealth;
    }

    public function setCurrentHealth(int $currentHealth) : void
    {
        if ($currentHealth > $maxHealth) {
            throw new \InvalidArgumentException('Cant set a health value bigger than Character max health.');
        }

        $this->currentHealth = $currentHealth;
    }
}
```
</td>
<td>
```php
class Character
{
    private int $currentHealth;

    public function __construct(
        private int $maxHealth
    ) {
        $currentHealth = $this->maxHealth;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(int $amount = 1) : void
    {
        $this->currentHealth = min(
            $this->maxHealth,
            $this->currentHealth + $amount
        );
    }

    public function hurt(int $amount = 1) : void
    {
        $this->currentHealth = max(
            0,
            $this->currentHealth - $amount
        );
    }
}
```
</td>
</tr>
</table>

Complétez la classe Character pour intégrer la gestion de l'équipement et du niveau; un personnage pour s'équiper d'un Equipement et monter de niveau.
Implémentez enfin une représentation de la puissance personnage : puissance = niveau + nb d'équipement - 1 pour chaque 2 blessures.

Ajoutez une nouvelle règle : à chaque montée en niveau, le maximum de points de vie augmente de 1, et le personnage est soigné de 1.
