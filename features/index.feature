Feature: index
  Scenario: An empty cart
    Given An Empty cart
    Then The number in cart is 0

  Scenario: Add products
    Given An Empty cart
    And the first luggage is added to the cart
    And the third luggage is added to the cart twice
    Then The number in cart is 3
