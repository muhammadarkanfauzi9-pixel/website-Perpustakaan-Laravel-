import './bootstrap';
import '../css/app.css';

// FilePond
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

// Register the plugin
FilePond.registerPlugin(FilePondPluginImagePreview);
