use std::env;
use std::fs::canonicalize;
use std::path::PathBuf;
use const_format::concatcp;

const CARGO_DIR: &str = env!("CARGO_MANIFEST_DIR");
const PHP_DIR: &str = concatcp!(CARGO_DIR, "/..");
const LIB_DIR: &str = concatcp!(PHP_DIR, "/libs");
const LIB_FILE: &str = concatcp!(LIB_DIR, "/libphp.so");
const LIB_HEADER: &str = concatcp!(PHP_DIR, "/sapi/embed/php_embed.h");

fn main() {
    // Tell cargo to look for shared libraries in the specified directory
    print!("cargo:rustc-link-search={}\n", canonicalize(LIB_DIR).unwrap().to_str().unwrap());
    // println!("cargo:rustc-link-lib=libphp");

    // let contents = fs::read_to_string(concatcp!(PHP_DIR, "/Makefile"))
    //     .expect("Cannot read Makefile");
    // let (_, split) = contents.split_at(contents.find("INCLUDES = ").unwrap());
    // let (line, _) = split.split_at(split.find("\n").unwrap());
    // let line = line.replace("INCLUDES = ", "");
    // let args = line.split(" ").collect::<Vec<&str>>();
    //
    // dbg!(&args);

    /*
    INCLUDES =
        -I/var/www/php-src/main
        -I/var/www/php-src
        -I/var/www/php-src/ext/date/lib
        -I/usr/include/libxml2
        -I/var/www/php-src/ext/lexbor
        -I/var/www/php-src/ext/uri/uriparser/include
        -I/var/www/php-src/TSRM
        -I/var/www/php-src/Zend
     */

    let mut args: Vec<String> = Vec::new();

    args.push(get_lib_include_arg("main".into()));
    args.push(get_lib_include_arg("".into()));
    args.push(get_lib_include_arg("ext/date/lib".into()));
    args.push(get_lib_include_arg("ext/lexbor".into()));
    args.push(get_lib_include_arg("ext/uri/uriparser/include".into()));
    args.push(get_lib_include_arg("TSRM".into()));
    args.push(get_lib_include_arg("Zend".into()));

    dbg!(&args);

    let bindings = bindgen::Builder::default()
        .clang_args(args)
        .header(canonicalize(LIB_HEADER).unwrap().to_str().unwrap())
        // Tell cargo to invalidate the built crate whenever any of the
        // included header files changed.
        .parse_callbacks(Box::new(bindgen::CargoCallbacks::new()))
        .generate()
        .expect("Unable to generate bindings");

    let out_path = PathBuf::from(CARGO_DIR);
    bindings
        .write_to_file(out_path.join("src/bindings.rs"))
        .expect("Couldn't write bindings!");
}

fn get_lib_include_arg(path: String) -> String {
    String::from(
        format!(
            "-I{}",
            canonicalize(format!("{}/{}", PHP_DIR, path))
                .unwrap()
                .to_str()
                .unwrap()
        )
    )
}
