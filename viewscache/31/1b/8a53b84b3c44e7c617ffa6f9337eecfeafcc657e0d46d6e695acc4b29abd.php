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
            'modals' => array($this, 'block_modals'),
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
        // line 45
        $this->displayBlock('modals', $context, $blocks);
        // line 98
        echo "

    <script>
        var items = ";
        // line 101
        echo twig_escape_filter($this->env, twig_jsonencode_filter((isset($context["items"]) ? $context["items"] : null)), "html", null, true);
        echo "
    </script>
";
    }

    // line 45
    public function block_modals($context, array $blocks = array())
    {
        // line 46
        echo "    <div id=\"jih-plan-hour\" class=\"modal fade\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
                    <h4 class=\"modal-title\">Schedule Prayer Hour</h4>
                </div>
                <form class=\"form-horizontal\" role=\"form\" action=\"/?<?= \$act ?>=SavePrayerHour\" method=\"post\">
                    <div class=\"modal-body\">
                            <div class=\"hide\">
                            <input id=\"jih-calendar-id\" type=\"text\" class=\"form-control\" name=\"scheduleId\" placeholder=\"Date\" value=\"1\">
                        </div>
                        <div class=\"form-group\">
                            <label for=\"jih-date\" class=\"col-sm-2 control-label\">Datetime</label>
                            <div class=\"col-sm-10\">
                                <input id=\"jih-date\" type=\"datetime\" class=\"form-control\" name=\"datetime\" placeholder=\"Date\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"jih-name\" class=\"col-sm-2 control-label\">Name</label>
                            <div class=\"col-sm-10\">
                                <input id=\"jih-name\" type=\"text\" class=\"form-control\" name=\"name\" placeholder=\"Name\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"jih-email\" class=\"col-sm-2 control-label\">Email</label>
                            <div class=\"col-sm-10\">
                                <input type=\"email\" class=\"form-control\" id=\"jih-email\" name=\"email\" placeholder=\"Email\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"jih-email\" class=\"col-sm-2 control-label\">Description</label>
                            <div class=\"col-sm-10\">
                                <textarea id=\"jih-description\" class=\"form-control\" rows=\"3\" name=\"description\" placeholder=\"Description\"></textarea>
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"jih-pin\" class=\"col-sm-2 control-label\">Pincode</label>
                            <div class=\"col-sm-10\">
                                <input type=\"text\" name=\"pin\" class=\"form-control\" id=\"jih-pin\" placeholder=\"Pin\">
                            </div>
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                        <button type=\"submit\" class=\"btn btn-primary\">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
        return array (  133 => 46,  130 => 45,  123 => 101,  118 => 98,  116 => 45,  107 => 38,  99 => 35,  88 => 33,  84 => 32,  78 => 31,  75 => 30,  71 => 29,  66 => 26,  56 => 23,  52 => 22,  32 => 4,  29 => 3,);
    }
}
