<% if $ButtonRows %>
        <% loop $ButtonRows %>
            <% if $Buttons %>
                <p> 
                    <% loop $Buttons %>
                        <a href="#" class="btn btn-info drag-button" draggable=true data-value="{$Value}">{$Label}</a>
                    <% end_loop %>
                </p>
            <% end_if %>
        <% end_loop %>
<% end_if %>

<textarea {$AttributesHTML}>{$ValueEntities.RAW}</textarea>