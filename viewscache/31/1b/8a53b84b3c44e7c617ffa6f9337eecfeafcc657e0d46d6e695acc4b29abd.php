<?php

/* day-view.twig */
class __TwigTemplate_311b8a53b84b3c44e7c617ffa6f9337eecfeafcc657e0d46d6e695acc4b29abd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("test.twig");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "test.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
<div id=\"post-2\" class=\"post-2 page type-page status-publish hentry\">

    <h2 class=\"page-title\">Prayer Calendar</h2>
    <div style=\"float:right;\">
        <select name=\"calendar\" id=\"jih-calendar\">
            <option value=\"12\">TestCalendar</option>
        </select>
        <a onclick=\"gotoToday()\" class=\"btn btn-primary\">Today</a>
        <a onclick=\"gotoLastWeek()\" class=\"btn btn-primary\">&lt;</a>
        <a onclick=\"gotoNextWeek()\" class=\"btn btn-primary\">&gt;</a>
    </div>


    <table id=\"jih-calendar-week\" class=\"table table-striped table-bordered calendar fixed\">
        <thead>
        <tr>
            <th></th>
            ";
        // line 22
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["dates"]) ? $context["dates"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["date"]) {
            // line 23
            echo "                <th>";
            echo twig_escape_filter($this->env, (isset($context["date"]) ? $context["date"] : null), "html", null, true);
            echo "</th>

            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['date'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "        </tr>
        </thead>
        <tbody>
        ";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range(0, 24));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 30
            echo "        <tr>
            <th>";
            // line 31
            echo twig_escape_filter($this->env, (isset($context["i"]) ? $context["i"] : null), "html", null, true);
            echo ":00 - ";
            echo twig_escape_filter($this->env, ((isset($context["i"]) ? $context["i"] : null) + 1), "html", null, true);
            echo ":00</th>
                ";
            // line 32
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["dates"]) ? $context["dates"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["date"]) {
                // line 33
                echo "                <td data-date=\"";
                echo twig_escape_filter($this->env, (isset($context["date"]) ? $context["date"] : null), "html", null, true);
                echo "\" data-time=\"";
                echo twig_escape_filter($this->env, (isset($context["i"]) ? $context["i"] : null), "html", null, true);
                echo ":00\"></td>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['date'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 35
            echo "        </tr>
        </tbody>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "    </table>
    <div class=\"entry clearfix\">
        <p>This is an example page. It’s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>

    </div>

</div>

";
    }

    public function getTemplateName()
    {
        return "day-view.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 38,  98 => 35,  87 => 33,  83 => 32,  77 => 31,  74 => 30,  70 => 29,  65 => 26,  55 => 23,  51 => 22,  31 => 4,  28 => 3,);
    }
}
