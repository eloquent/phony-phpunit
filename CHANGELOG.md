# Phony for PHPUnit changelog

## Next release

- **[BC BREAK]** PHP 5 is no longer supported ([#216]).
- **[BC BREAK]** HHVM is no longer supported ([#216], [#219]).
- **[BC BREAK]** Removed `inOrderSequence`, `checkInOrderSequence`,
  `anyOrderSequence`, and `checkAnyOrderSequence` from the facade ([#215]).
- **[NEW]** Implemented `anInstanceOf()` ([#220]).
- **[NEW]** Implemented `emptyValue()` ([#218]).
- **[IMPROVED]** Support for PHP 7.2 features, including the `object` typehint
  ([#224]).
- **[IMPROVED]** Reduced the amount of output generated when mocks, stubs, and
  spies are encountered by `var_dump()` ([#223]).

[#215]: https://github.com/eloquent/phony/issues/215
[#216]: https://github.com/eloquent/phony/issues/216
[#218]: https://github.com/eloquent/phony/issues/218
[#219]: https://github.com/eloquent/phony/issues/219
[#220]: https://github.com/eloquent/phony/issues/220
[#223]: https://github.com/eloquent/phony/issues/223
[#224]: https://github.com/eloquent/phony/issues/224

## 2.0.0 (2017-04-24)

- **[NEW]** Support for PHPUnit 6.
- **[BC BREAK]** Dropped support for PHP < 7.

## 1.0.0 (2017-04-24)

- **[IMPROVED]** Updated to use the new Phony `1.0.0` release.

## 0.1.0 (2017-04-23)

- **[NEW]** Initial release.
