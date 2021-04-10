# Changelog

All notable changes to `laravel-actionable-model` will be documented in this file.

## 1.3.2 - 2021-03-31

- Add support for updating just a specific alias
- Code refactoring

## 1.3.0 - 2021-03-31

- Add `actionable:type` command to create an actionType class.
- Add Aliases to your Actionable Models. `App\Models\User` => `user`.
- Add `actionable:update-aliases` command to update all the current records using the model path to use the aliases.
- Add new `first` and `last` method to the actionsFilter

## 1.2.0 - 2021-03-22

- Add `latest` method to the actionsFilter

## 1.1.1 - 2021-03-22

- Improve README and keywords

## 1.1.0 - 2021-03-22

- Now, you can eager load your actions. `User::with('actions')` 
- Add a new method `actionsHandler` to your models to help you filter the actions.

## 1.0.0 - 2021-03-21

- initial release
