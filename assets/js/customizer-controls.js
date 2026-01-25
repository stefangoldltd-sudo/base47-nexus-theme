/**
 * Base47 Theme Customizer Controls
 * Enhanced customizer interface and controls
 */

(function($) {
    'use strict';

    wp.customize.bind('ready', function() {
        
        // Add custom CSS for better customizer UI
        var customCSS = `
            <style>
                .customize-control-title {
                    font-weight: 600;
                    margin-bottom: 8px;
                }
                
                .customize-control-description {
                    font-style: italic;
                    color: #666;
                    margin-bottom: 10px;
                }
                
                .customize-section-title {
                    border-left: 4px solid #ff4d00;
                    padding-left: 12px;
                    font-weight: 700;
                }
                
                /* Base47 HTML Editor Section Styling */
                #customize-control-base47_canvas_mode_default,
                #customize-control-base47_auto_detect_templates,
                #customize-control-base47_marketplace_integration {
                    background: #f8f9fa;
                    padding: 15px;
                    border-radius: 6px;
                    margin-bottom: 15px;
                    border-left: 4px solid #ff4d00;
                }
                
                /* Color Controls */
                .customize-control-color .wp-color-result {
                    border-radius: 4px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                
                /* Range Controls */
                .customize-control-range input[type="range"] {
                    width: 100%;
                    margin: 10px 0;
                }
                
                /* Select Controls */
                .customize-control-select select {
                    width: 100%;
                    padding: 8px 12px;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                }
                
                /* Checkbox Controls */
                .customize-control-checkbox input[type="checkbox"] {
                    margin-right: 8px;
                    transform: scale(1.2);
                }
                
                /* Section Icons */
                .control-section .accordion-section-title:before {
                    font-family: 'Font Awesome 5 Free', dashicons;
                    font-weight: 900;
                    margin-right: 8px;
                }
                
                #accordion-section-base47_html_editor .accordion-section-title:before {
                    content: "🚀";
                }
                
                #accordion-section-base47_colors .accordion-section-title:before {
                    content: "🎨";
                }
                
                #accordion-section-base47_typography .accordion-section-title:before {
                    content: "📝";
                }
                
                #accordion-section-base47_layout .accordion-section-title:before {
                    content: "📐";
                }
                
                #accordion-section-base47_header .accordion-section-title:before {
                    content: "🔝";
                }
                
                #accordion-section-base47_footer .accordion-section-title:before {
                    content: "🔻";
                }
                
                #accordion-section-base47_blog .accordion-section-title:before {
                    content: "📰";
                }
                
                #accordion-section-base47_performance .accordion-section-title:before {
                    content: "⚡";
                }
                
                #accordion-section-base47_page_builders .accordion-section-title:before {
                    content: "🔧";
                }
            </style>
        `;
        
        $('head').append(customCSS);
        
        // Add tooltips to controls
        $('.customize-control').each(function() {
            var $control = $(this);
            var description = $control.find('.customize-control-description').text();
            
            if (description) {
                $control.find('.customize-control-title').attr('title', description);
            }
        });
        
        // Enhanced color picker
        $('.wp-color-picker').wpColorPicker({
            change: function(event, ui) {
                var color = ui.color.toString();
                $(this).trigger('change');
            },
            clear: function() {
                $(this).trigger('change');
            }
        });
        
        // Font preview functionality
        function loadGoogleFont(fontName) {
            if (fontName && fontName !== 'inherit') {
                var fontUrl = 'https://fonts.googleapis.com/css2?family=' + fontName.replace(' ', '+') + ':wght@300;400;500;600;700&display=swap';
                if (!$('link[href="' + fontUrl + '"]').length) {
                    $('head').append('<link href="' + fontUrl + '" rel="stylesheet">');
                }
            }
        }
        
        // Load fonts when customizer opens
        var bodyFont = wp.customize('base47_body_font')();
        var headingFont = wp.customize('base47_heading_font')();
        
        if (bodyFont) loadGoogleFont(bodyFont);
        if (headingFont) loadGoogleFont(headingFont);
        
        // Font select change handlers
        wp.customize.control('base47_body_font', function(control) {
            control.setting.bind(function(value) {
                loadGoogleFont(value);
            });
        });
        
        wp.customize.control('base47_heading_font', function(control) {
            control.setting.bind(function(value) {
                loadGoogleFont(value);
            });
        });
        
        // Range slider value display
        $('.customize-control-range').each(function() {
            var $control = $(this);
            var $input = $control.find('input[type="range"]');
            var $valueDisplay = $('<span class="range-value"></span>');
            
            $input.after($valueDisplay);
            
            function updateValue() {
                var value = $input.val();
                var unit = '';
                
                if ($input.attr('id').indexOf('font_size') !== -1 || 
                    $input.attr('id').indexOf('width') !== -1 || 
                    $input.attr('id').indexOf('height') !== -1) {
                    unit = 'px';
                }
                
                $valueDisplay.text(value + unit);
            }
            
            updateValue();
            $input.on('input change', updateValue);
        });
        
        // Section dependency logic
        function toggleSectionVisibility() {
            // Hide page builder section if no page builders are detected
            var pageBuilderSection = wp.customize.section('base47_page_builders');
            var hasPageBuilders = false;
            
            // Check for common page builders
            if (typeof elementor !== 'undefined' || 
                typeof FLBuilder !== 'undefined' || 
                typeof vc !== 'undefined') {
                hasPageBuilders = true;
            }
            
            if (pageBuilderSection && !hasPageBuilders) {
                pageBuilderSection.container.hide();
            }
        }
        
        toggleSectionVisibility();
        
        // Add reset buttons to sections
        $('.control-section').each(function() {
            var $section = $(this);
            var sectionId = $section.attr('id').replace('accordion-section-', '');
            
            if (sectionId.indexOf('base47_') === 0) {
                var $resetButton = $('<button type="button" class="button button-secondary section-reset" style="margin: 10px 12px;">Reset Section</button>');
                
                $resetButton.on('click', function(e) {
                    e.preventDefault();
                    
                    if (confirm('Are you sure you want to reset all settings in this section?')) {
                        // Find all controls in this section and reset them
                        wp.customize.section(sectionId).controls().forEach(function(control) {
                            if (control.setting) {
                                control.setting.set(control.setting._value._default);
                            }
                        });
                    }
                });
                
                $section.find('.accordion-section-content').append($resetButton);
            }
        });
        
        // Add export/import functionality
        var $exportImport = $(`
            <div class="base47-export-import" style="padding: 15px; background: #f8f9fa; margin: 15px 12px; border-radius: 6px;">
                <h4>Export/Import Settings</h4>
                <button type="button" class="button button-primary export-settings" style="margin-right: 10px;">Export Settings</button>
                <button type="button" class="button button-secondary import-settings">Import Settings</button>
                <input type="file" id="import-file" accept=".json" style="display: none;">
            </div>
        `);
        
        $('#customize-theme-controls').append($exportImport);
        
        // Export functionality
        $('.export-settings').on('click', function() {
            var settings = {};
            
            wp.customize.each(function(setting) {
                if (setting.id.indexOf('base47_') === 0) {
                    settings[setting.id] = setting.get();
                }
            });
            
            var dataStr = JSON.stringify(settings, null, 2);
            var dataBlob = new Blob([dataStr], {type: 'application/json'});
            var url = URL.createObjectURL(dataBlob);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = 'base47-theme-settings.json';
            link.click();
            
            URL.revokeObjectURL(url);
        });
        
        // Import functionality
        $('.import-settings').on('click', function() {
            $('#import-file').click();
        });
        
        $('#import-file').on('change', function(e) {
            var file = e.target.files[0];
            if (!file) return;
            
            var reader = new FileReader();
            reader.onload = function(e) {
                try {
                    var settings = JSON.parse(e.target.result);
                    
                    if (confirm('This will overwrite your current theme settings. Are you sure?')) {
                        Object.keys(settings).forEach(function(settingId) {
                            var setting = wp.customize(settingId);
                            if (setting) {
                                setting.set(settings[settingId]);
                            }
                        });
                        
                        alert('Settings imported successfully!');
                    }
                } catch (error) {
                    alert('Error importing settings: Invalid file format');
                }
            };
            
            reader.readAsText(file);
        });
        
    });

})(jQuery);