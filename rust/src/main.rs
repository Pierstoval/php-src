use libloading::Library;
use libloading::Symbol;
use std::env;
use std::ffi::CString;
use std::os::raw::c_char;
use std::os::raw::c_int;
use std::os::raw::c_void;
use const_format::concatcp;

// mod bindings;

const CARGO_DIR: &str = env!("CARGO_MANIFEST_DIR");
const PHP_DIR: &str = concatcp!(CARGO_DIR, "/..");
const LIB_FILE: &str = concatcp!(PHP_DIR, "/.libs/libphp.so");

type PhpEmbedInit = unsafe extern "C" fn(argc: c_int, argv: *const c_char) -> u32;
type PhpEmbedShutdown = unsafe extern "C" fn() -> c_void;
type ZendEvalString = unsafe extern "C" fn(
    str: *const c_char,
    retval_ptr: *mut c_void,
    string_name: *const c_char,
) -> *mut c_void;

fn main() {
    run_php();

    exec_raw_php();
}

fn run_php() {

    unsafe {
        // Load the shared library
        let lib = Library::new(LIB_FILE).expect("Failed to load libphp.so");

        // Load the function symbols
        let php_embed_init: Symbol<PhpEmbedInit> = lib
            .get(b"php_embed_init")
            .expect("Failed to load php_embed_init");
        let php_embed_shutdown: Symbol<PhpEmbedShutdown> = lib
            .get(b"php_embed_shutdown")
            .expect("Failed to load php_embed_shutdown");

        // Initialize PHP
        php_embed_init(0, std::ptr::null());

        // Example: Execute PHP code from a String
        let php_code = String::from("
        echo 'Hello from PHP, executed from Rust!'.PHP_EOL;

        echo '__FILE__: '.__FILE__.PHP_EOL;

        echo 'SAPI: ', PHP_SAPI, PHP_EOL;
        ");

        match execute_php_code(&lib, &php_code) {
            Ok(_) => (),
            Err(e) => eprintln!("[ERR] Error executing PHP code: {}", e),
        }

        // Shutdown PHP
        php_embed_shutdown();

        // Keep the library loaded for the duration of the program
        std::mem::forget(lib);
    }
}

fn execute_php_code(lib: &Library, php_code: &str) -> Result<(), String> {
    unsafe {
        // Load the zend_eval_string function
        let zend_eval_string: Symbol<ZendEvalString> = lib
            .get(b"zend_eval_string")
            .map_err(|e| format!("Failed to load zend_eval_string: {}", e))?;

        // Convert the PHP code to a C string
        let code_cstring = CString::new(php_code)
            .map_err(|e| format!("Failed to convert PHP code to C string: {}", e))?;

        let string_name = CString::new("Rust executed code")
            .map_err(|e| format!("Failed to create string name: {}", e))?;

        // Execute the PHP code
        zend_eval_string(
            code_cstring.as_ptr(),
            std::ptr::null_mut(),
            string_name.as_ptr(),
        );

        Ok(())
    }
}

fn exec_raw_php () {
    // println!("Native PHP_VERSION:");
    // dbg!(bindings::PHP_VERSION);
}
