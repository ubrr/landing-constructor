import React from 'react';
import ReactDom from 'react-dom';
import { Calculator } from "./components/Calculator";
import { useParams } from "./hooks/Constants";

export default function calculatorFormComponent(editor) {
    const comps = editor.DomComponents;
    const { typeFromCalculator } = useParams();

    for (let key in typeFromCalculator) {
        comps.addType('calculatorForm' + typeFromCalculator[key], {
            model: {
                defaults: {
                    tagName: 'div',
                    droppable: true,
                    editable: true,
                    selectable: true,
                    attributes: {
                        class: 'calculator_form_container',
                        credittitle: typeFromCalculator[key]
                    },
                }
            },

            view: {
                init() {
                    this.listenTo(this.model, 'change:sectionColorClass', this.handleChanges);
                },
                handleChanges() {
                    ReactDom.unmountComponentAtNode(this.el);
                    this.render();
                },
                onRender() {
                    ReactDom.render(<Calculator creditTitle={typeFromCalculator[key]} />, this.el);
                },
            }
        });

        editor.BlockManager.add('calculator_form' + typeFromCalculator[key], {
            label: 'Calculator form ' + typeFromCalculator[key],
            category: 'Custom Section',
            attributes: {
                class:'fa fa-square'
            },
            content: {
                type: 'calculatorForm' + typeFromCalculator[key]
            }
        });
    }
}
