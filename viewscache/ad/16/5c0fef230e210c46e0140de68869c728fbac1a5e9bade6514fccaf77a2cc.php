<?php

/* test.twig */
class __TwigTemplate_ad165c0fef230e210c46e0140de68869c728fbac1a5e9bade6514fccaf77a2cc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head lang=\"en\">
    <meta charset=\"UTF-8\">
    <title></title>
</head>
<body>
";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["yolo"]) ? $context["yolo"] : null), "html", null, true);
        echo "
</body>
</html>";
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
        return array (  28 => 8,  19 => 1,);
    }
}
