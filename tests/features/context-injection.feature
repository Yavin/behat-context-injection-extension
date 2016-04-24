Feature: Injecting contexts
  In order the context B to be injected in to context A method
  i need to declare

  Scenario: Injecting to method
    Then I can inject context as standalone argument
    And I can inject context as first argument beside "model"
    And I can inject context as last argument beside "model"
    And I can inject context as middle argument beside "model" and "model"
    And I can inject context in table method as first argument:
      | Like |
      | that |
    And I can inject context in table method as last argument:
      | Like |
      | that |
