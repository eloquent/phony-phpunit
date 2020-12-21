# Phony for PHPUnit changelog

## 7.1.0 (2020-12-21)

This release uses *Phony* `5.x`. There no BC breaking API changes.

## 7.0.0 (2020-02-12)

- **[BC BREAK]** PHP 7.2 is no longer supported.
- **[BC BREAK]** Dropped support for PHPUnit `8.x`.
- **[NEW]** Added support for PHPUnit `9.x`.

## 6.0.0 (2020-01-06)

This release uses *Phony* `4.x`. There no BC breaking API changes aside from
stricter type declarations.

- **[BC BREAK]** PHP 7.1 is no longer supported.

## 5.0.0 (2019-02-05)

- **[BC BREAK]** Dropped support for PHPUnit `7.x` ([#3], [#4]).
- **[NEW]** Added support for PHPUnit `8.x` ([#3], [#4]).

[#3]: https://github.com/eloquent/phony-phpunit/pull/3
[#4]: https://github.com/eloquent/phony-phpunit/pull/4

## 4.0.1 (2018-04-05)

- **[MAINTENANCE]** Updated required PHPUnit version to avoid coverage issues
  ([#2]).

[#2]: https://github.com/eloquent/phony-phpunit/pull/2

## 4.0.0 (2018-03-20)

This release uses *Phony* `3.x` under the hood. Check out the
[migration guide][migration-3] for *Phony* `3.x`, which also applies to this
release.

- **[BC BREAK]** PHP 7.0 is no longer supported ([#1]).
- **[NEW]** Support for PHPUnit 7 ([#1]).

[migration-3]: https://github.com/eloquent/phony/blob/master/MIGRATING.md#migrating-from-2x-to-3x
[#1]: https://github.com/eloquent/phony-phpunit/issues/1

## 3.0.0 (2017-09-29)

This release uses *Phony* `2.x` under the hood. Check out the
[migration guide][migration-2] for *Phony* `2.x`, which also applies to this
release.

- **[BC BREAK]** HHVM is no longer supported ([#216], [#219]).
- **[BC BREAK]** Removed `inOrderSequence`, `checkInOrderSequence`,
  `anyOrderSequence`, and `checkAnyOrderSequence` from the facade ([#215]).
- **[BC BREAK]** Stubs created outside of a mock now have their "self" value set
  to the stub itself, instead of the stubbed callback ([#226]).
- **[NEW]** Implemented `anInstanceOf()` ([#220]).
- **[NEW]** Implemented `emptyValue()` ([#218]).
- **[IMPROVED]** Support for PHP 7.2 features, including the `object` typehint
  ([#224]).
- **[IMPROVED]** Improved the error message produced when a default return value
  cannot be produced, because the return type is a final class ([#228]).
- **[IMPROVED]** Reduced the amount of output generated when mocks, stubs, and
  spies are encountered by `var_dump()` ([#223]).

[migration-2]: https://github.com/eloquent/phony/blob/master/MIGRATING.md#migrating-from-1x-to-2x
[#215]: https://github.com/eloquent/phony/issues/215
[#216]: https://github.com/eloquent/phony/issues/216
[#218]: https://github.com/eloquent/phony/issues/218
[#219]: https://github.com/eloquent/phony/issues/219
[#220]: https://github.com/eloquent/phony/issues/220
[#223]: https://github.com/eloquent/phony/issues/223
[#224]: https://github.com/eloquent/phony/issues/224
[#226]: https://github.com/eloquent/phony/issues/226
[#228]: https://github.com/eloquent/phony/issues/228

## 2.0.0 (2017-04-24)

- **[NEW]** Support for PHPUnit 6.
- **[BC BREAK]** Dropped support for PHP < 7.

## 1.0.0 (2017-04-24)

- **[IMPROVED]** Updated to use the new Phony `1.0.0` release.

## 0.1.0 (2017-04-23)

- **[NEW]** Initial release.
