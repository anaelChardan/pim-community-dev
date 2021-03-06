<?php

namespace spec\Akeneo\Test\Common\Structure\Attribute;

use Akeneo\Test\Common\Structure\Attribute\Builder;
use PhpSpec\ObjectBehavior;
use Akeneo\Pim\Structure\Component\AttributeTypes;

class BuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Builder::class);
    }

    function it_builds_an_attribute_with_default_value()
    {
        $attribute = $this->build();
        $attribute->getType()->shouldReturn(AttributeTypes::IDENTIFIER);
        $attribute->getCode()->shouldReturn('code');
        $attribute->isUnique()->shouldReturn(false);

    }

    function it_builds_an_identifier_attribute()
    {
        $this->withCode('metric');
        $this->aIdentifier();

        $attribute = $this->build();
        $attribute->getType()->shouldReturn(AttributeTypes::IDENTIFIER);
        $attribute->getCode()->shouldReturn('metric');
        $attribute->isUnique()->shouldReturn(true);
        $attribute->isLocalizable()->shouldReturn(false);
        $attribute->isScopable()->shouldReturn(false);
    }

    function it_builds_a_unique_attribute()
    {
        $this->withCode('name');
        $this->aUniqueAttribute();

        $attribute = $this->build();
        $attribute->getType()->shouldReturn(AttributeTypes::TEXT);
        $attribute->getCode()->shouldReturn('name');
        $attribute->isUnique()->shouldReturn(true);
        $attribute->isLocalizable()->shouldReturn(false);
        $attribute->isScopable()->shouldReturn(false);
    }

    function it_builds_a_text_attribute()
    {
        $this->aTextAttribute();

        $attribute = $this->build();
        $attribute->getType()->shouldReturn(AttributeTypes::TEXT);
        $attribute->getCode()->shouldReturn('code');
        $attribute->isUnique()->shouldReturn(false);
        $attribute->isLocalizable()->shouldReturn(false);
        $attribute->isScopable()->shouldReturn(false);
    }

    function its_code_is_mutable()
    {
        $this->withCode('code')->shouldReturn($this);
    }

    function it_will_build_an_identifier()
    {
        $this->aIdentifier()->shouldReturn($this);
    }
}
