
import { render } from '@wordpress/element';
import ManageFonts from './manage-fonts';
import GoogleFonts from './google-fonts';
import LocalFonts from './local-fonts';
import { ManageFontsProvider } from './fonts-context';
import { createRoot } from '@wordpress/element';

function App() {	
	const params = new URLSearchParams( document.location.search );
	const page = params.get( 'page' );
    const { adminUrl, fontLibSlug } = dragBlockFontLib;
    
	let PageComponent = null;
	switch ( page ) {
		case fontLibSlug:
			PageComponent = ManageFonts;
			break;
		case 'dragblock-add-google-fonts':
			PageComponent = GoogleFonts;
			break;
		case 'dragblock-add-local-fonts':
			PageComponent = LocalFonts;
			break;
		default:
			PageComponent = () => <h1>This page is not implemented yet.</h1>;
			break;
	}

	return (
		<ManageFontsProvider>
			<PageComponent />
		</ManageFontsProvider>
	);
}

window.addEventListener(
	'load',
	function () {
		const domNode = document.querySelector( '#dragblock-font-library-app' );



		if ( createRoot === undefined ) {
			render( <App />, domNode );
		} else {
			const root = createRoot( domNode );
			root.render( <App /> );
		}

		

	},
	false
);

