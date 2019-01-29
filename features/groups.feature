Feature: Groups feature
  Scenario: Adding a new group
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups" with body:
    """
    {
        "name":"Test Group"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 4 elements
    And the JSON node "data.name" should contain "Test Group"
    And the JSON node "data.user_ids" should have 0 elements


  Scenario: Updating an existing group
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups/1" with body:
    """
    {
        "name":"Test Group",
        "user_ids":[1,2]
    }
    """
    Then the response status code should be 204
    And the response should be empty


  Scenario: Viewing group list after creating one
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups" with body:
    """
    {
        "name":"Test Group",
        "user_ids":[1,2]
    }
    """
    And I send a "GET" request to "/api/v1/groups"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 4 elements


  Scenario: Viewing a group after updating it
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups/3" with body:
    """
    {
        "name":"Test Group Another",
        "user_ids":[3,4]
    }
    """
    And I send a "GET" request to "/api/v1/groups/3"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 4 elements
    And the JSON node "data.name" should contain "Test Group Another"
    And the JSON node "data.user_ids" should have 2 elements



  Scenario: Modifying user of a group
    Given I add "Accept" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups" with body:
    """
    {
        "name":"Test Group New",
        "user_ids":[1,2]
    }
    """
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/api/v1/groups/4" with body:
    """
    {
        "user_ids":[3]
    }
    """
    And I send a "GET" request to "/api/v1/groups/4"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "data" should have 4 elements
    And the JSON node "data.name" should be equal to "Test Group New"
    And the JSON node "data.user_ids" should have 1 element