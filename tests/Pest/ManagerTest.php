<?php

use ArchTech\SEO\SEOManager;

test('set returns the set value', function () {
    expect(seo()->set('foo', 'bar'))->toBe('bar');
});

test('the __call proxy is chainable', function () {
    expect(seo()->foo('bar'))->toBeInstanceOf(SEOManager::class);
});

test('default values can be set in the proxy call', function () {
    seo()->title(default: 'foo');
    expect(seo('title'))->toBe('foo');

    seo()->title('bar');
    expect(seo('title'))->toBe('bar');
});

test('default values can be set in the proxy call alongside the value', function () {
    seo()->description('bar', default: 'foo');

    expect(seo('description'))->toBe('bar');
});

test('metadata can be used as strings', function () {
    seo()->meta('foo', 'bar');

    expect(seo()->meta('foo'))->toBe('bar');
});

test('metadata can be used as arrays', function () {
    seo()->meta('abc', ['def' => 'xyz']);
    expect(seo()->meta('abc.def'))->toBe('xyz');

    seo()->meta('abc.def', 'xxx');
    expect(seo()->meta('abc.def'))->toBe('xxx');

    seo()->meta(['abc.def' => 'yyy']);
    expect(seo()->meta('abc.def'))->toBe('yyy');
});

test('values can be set magically', function () {
    seo()->foo = 'bar';

    expect(seo('foo'))->toBe('bar');
    expect(seo()->foo)->toBe('bar');
});

test('magic access respects modifiers', function () {
    seo()->foo(modify: 'strtoupper');

    seo()->foo = 'bar';

    expect(seo('foo'))->toBe('BAR');
    expect(seo()->foo)->toBe('BAR');
});

test('magic access gets converted to dot syntax', function () {
    seo()->fooBar('baz');
    expect(seo('foo.bar'))->toBe('baz');
    expect(seo()->fooBar)->toBe('baz');

    seo()->abcDef = 'xyz';
    expect(seo('abc.def'))->toBe('xyz');
    expect(seo()->abcDef)->toBe('xyz');
});