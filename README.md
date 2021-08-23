# Async

Async library powered by ReactPHP (WIP)

Implementing Command and Query Bus
----------------------------------

```yaml
framework:
    messenger:
        default_bus: command.bus
        buses:
            command.bus:
                middleware:
                    - validation
            query.bus:
                middleware:
                    - validation
            event.bus:
                default_middleware: allow_no_handlers
                middleware:
                    - validation
```
