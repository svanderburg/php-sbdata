{ nixpkgs ? <nixpkgs> }:

let
  pkgs = import nixpkgs {};
in
{
  doc = pkgs.stdenv.mkDerivation {
    name = "php-sbdata-doc";
    src = ./sbdata;
    buildInputs = [ pkgs.doxygen ];
    buildPhase = ''
      make doc
    '';
    installPhase = ''
      mkdir -p $out/nix-support
      cp -av apidoc $out
      echo "doc api $out/apidoc/html" >> $out/nix-support/hydra-build-products
    '';
  };
}