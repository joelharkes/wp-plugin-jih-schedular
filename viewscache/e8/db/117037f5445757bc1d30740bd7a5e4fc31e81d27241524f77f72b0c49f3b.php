<?php

/* test.twig */
class __TwigTemplate_e8db117037f5445757bc1d30740bd7a5e4fc31e81d27241524f77f72b0c49f3b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "

";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('get_header')->getCallable(), array()), "html", null, true);
        echo "

<div id=\"wrap\" class=\"container clearfix template-frontpage\">
    <section id=\"content\" class=\"primary\" role=\"main\">

        ";
        // line 8
        $this->displayBlock('content', $context, $blocks);
        // line 11
        echo "

    </section>
    ";
        // line 14
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('get_sidebar')->getCallable(), array()), "html", null, true);
        echo "
    <?php  ?>


</div>

";
        // line 20
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('get_footer')->getCallable(), array()), "html", null, true);
        echo "
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "            this is the content section
        ";
    }

    public function getTemplateName()
    {
        return "test.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 9,  54 => 8,  48 => 20,  39 => 14,  34 => 11,  32 => 8,  24 => 3,  20 => 1,);
    }
}
