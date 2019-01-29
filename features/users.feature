Feature: Users feature
  Scenario: Adding a new user
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/users" with body:
    """
    {
        "email": "okwinza2@yandex.com",
        "firstName": "Oleg",
        "LastName": "PHP",
        "active": true,
        "group_id": 1
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 7 elements
    And the JSON node "data.email" should contain "okwinza2@yandex.com"
    And the JSON node "data.group_data.id" should contain "1"
    And the JSON node "data.is_active" should be true


  Scenario: Updating an existing user
    Given I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/users/1" with body:
    """
    {
        "email": "okwinza2@test.com",
        "firstName": "Oleg2",
        "LastName": "PHP3",
        "active": false,
        "group_id": 2
    }
    """
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/v1/users/1"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 7 elements
    And the JSON node "data.email" should contain "okwinza2@test.com"
    And the JSON node "data.group_data.id" should contain "2"
    And the JSON node "data.is_active" should be false


  Scenario: Viewing user list after creating one
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/users" with body:
    """
    {
        "email": "okwinza2@yandex.com",
        "firstName": "Oleg",
        "LastName": "PHP",
        "active": true,
        "group_id": 1
    }
    """
    And I send a "GET" request to "/api/v1/users"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 6 elements
