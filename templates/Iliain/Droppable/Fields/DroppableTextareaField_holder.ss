<div id="{$HolderID}" class="form-group field<% if $extraClass %> {$extraClass}<% end_if %>">
    <% if $Title %>
        <label class="form__field-label" for="{$ID}">
            <h2>{$Title}</h2>
            <% if $LeftDescription %><p>{$LeftDescription}</p><% end_if %>
        </label>
    <% end_if %>
    <div id="{$ID}" class="form__field-holder">
        {$Field}
        <% if $Message %><span class="message {$MessageType}">{$Message}</span><% end_if %>
        <% if $Description %><span class="description">{$Description}</span><% end_if %>
    </div>
    <% if $RightTitle %><label class="right" for="{$ID}">{$RightTitle}</label><% end_if %>
</div>
