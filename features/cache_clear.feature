Feature: Cache clear command
  In order to benchmark spec generation
  As an Uspec developer
  I need to clean application cache

  Scenario: Running cache:clear command
    When I run "cache:clear" command
    Then I should see "/Cleaning application cache .../"
    And I should see "/Done/"
