<script setup>
import { ref } from "vue";
import Editor from "@tinymce/tinymce-vue";

import InputLabel from "@/admin/Components/InputLabel.vue";
import InputError from "@/admin/Components/InputError.vue";


import {
	ClassicEditor,
	AccessibilityHelp,
	Autosave,
	Bold,
	Code,
	Essentials,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	FontSize,
	Highlight,
	Italic,
	Paragraph,
	RemoveFormat,
	SelectAll,
	SpecialCharacters,
	SpecialCharactersArrows,
	SpecialCharactersCurrency,
	SpecialCharactersEssentials,
	SpecialCharactersLatin,
	SpecialCharactersMathematical,
	SpecialCharactersText,
	Strikethrough,
	Subscript,
	Superscript,
	Underline,
	Undo
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';
import 'ckeditor5-premium-features/ckeditor5-premium-features.css';

defineProps({
    modelValue: {},
    label: {
        type: String,
        default: "",
    },
    errorMessage: {
        type: String,
        default: "",
    },
});

const config = ref({
    height: 300,
});

const editor = ClassicEditor
const editorConfig = {
    toolbar: {
			items: [
				'undo',
				'redo',
				'|',
				'selectAll',
				'|',
				'fontSize',
				'fontFamily',
				'fontColor',
				'fontBackgroundColor',
				'|',
				'bold',
				'italic',
				'underline',
				'strikethrough',
				'subscript',
				'superscript',
				'code',
				'removeFormat',
				'|',
				'specialCharacters',
				'highlight',
				'|',
				'accessibilityHelp'
			],
			shouldNotGroupWhenFull: false
		},
		plugins: [
			AccessibilityHelp,
			Autosave,
			Bold,
			Code,
			Essentials,
			FontBackgroundColor,
			FontColor,
			FontFamily,
			FontSize,
			Highlight,
			Italic,
			Paragraph,
			RemoveFormat,
			SelectAll,
			SpecialCharacters,
			SpecialCharactersArrows,
			SpecialCharactersCurrency,
			SpecialCharactersEssentials,
			SpecialCharactersLatin,
			SpecialCharactersMathematical,
			SpecialCharactersText,
			Strikethrough,
			Subscript,
			Superscript,
			Underline,
			Undo
		],
		fontFamily: {
			supportAllValues: true
		},
		fontSize: {
			options: [10, 12, 14, 'default', 18, 20, 22],
			supportAllValues: true
		},
}
</script>

<template>
    <div>
        <InputLabel v-if="label"
               :value="label" />
        <!-- <editor api-key="jpamoi4osp74tob1cw02x5sn5vu8g2hf8b77x8t16kew9tdk"
                :model-value="modelValue"
                @update:model-value="$emit('update:modelValue', $event)"
                :init="config"
                v-bind="$attrs" /> -->
            <ckeditor
                :model-value="modelValue"
                @update:model-value="$emit('update:modelValue', $event)"
                v-bind="$attrs"
                :editor="editor"
                :config="editorConfig"
            />

        <InputError v-if="errorMessage"
                    class="mt-1"
                    :message="errorMessage" />
    </div>
</template>