<?php

namespace spec\Sugarcrm\UpgradeSpec\Purifier;

use Sugarcrm\UpgradeSpec\Purifier\Html;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://domain.com/', [
            'absolute_urls' => true,
            'no_tag_duplicates' => true,
            'pre_to_code' => true,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Html::class);
    }

    function it_validates_given_options()
    {
        $this->beConstructedWith('', [
            'absolute_urls' => true,
        ]);

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_converts_all_urls_to_absolute_form()
    {
        $html = <<<EOD
<a href="/1.html" target="_blank">aaa</a>
<a href="/aaa/../2.html" target="_blank">bbb</a>
<a href="/aaa/./3.html" target="_blank">ccc</a>
<a href="http://another.domain.com/1.html" target="_blank">ddd</a>
EOD;
        $purified = <<<EOD
<a href="http://domain.com/1.html" target="_blank">aaa</a>
<a href="http://domain.com/2.html" target="_blank">bbb</a>
<a href="http://domain.com/aaa/3.html" target="_blank">ccc</a>
<a href="http://another.domain.com/1.html" target="_blank">ddd</a>
EOD;

        $this->purify($html)->shouldContain($purified);
    }

    function it_removes_tag_duplicates()
    {
        $html = <<<EOD
<b><strong><b>aaa</b></strong></b>
<b>   <strong> <b>bbb</b></strong> </b>
<b><b>ccc</b></b>
EOD;
        $purified = <<<EOD
<b>aaa bbb ccc</b>
EOD;

        $this->purify($html)->shouldContain($purified);
    }

    function it_converts_pre_to_code()
    {
        $html = <<<EOD
<pre>aaa</pre>
EOD;
        $purified = <<<EOD
<code>aaa</code>
EOD;

        $this->purify($html)->shouldContain($purified);
    }
}
